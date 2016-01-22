<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Cache;

class Achievements extends Model {

    /**
     * @var string
     */
    protected $table = 'achievements';

    /**
     * @var array
     */
    protected $fillable = ['title','path','icon','difficulty','points','criteria_text','criteria_show','category_id','subcategory_id'];

    public function getCount()
    {
        return Cache::get('Achievements_count', function() {
            return parent::count();
        });
    }

   public function getPoints()
    {
        $query = $this->select(
            DB::RAW(' ROUND(SUM(points),0) as allpoints  ')
        )->first();
        if(!empty($query))
        return (int)$query->allpoints;
        else return 0;
    }

    /**
     * List
     * @return mixed
     */
    public static function getList()
    {
        return parent::select('achievements.*',
                        'cat.title as category_title',
                        'subcat.title as sub_category_title'
                        )
                       ->leftJoin('achievements_categories as cat','cat.id','=','achievements.category_id')
                       ->leftJoin('achievements_categories as subcat','subcat.id','=','achievements.subcategory_id')
                       ->paginate(25);
    }

    /**
     * @param $word
     * @return mixed
     */
    public static function getSearchList($word)
    {
        return parent::select('achievements.*',
            'cat.title as category_title',
            'subcat.title as sub_category_title'
            )
            ->leftJoin('achievements_categories as cat','cat.id','=','achievements.category_id')
            ->leftJoin('achievements_categories as subcat','subcat.id','=','achievements.subcategory_id')
            ->where('achievements.title', 'like', '%' . $word . '%')
            ->orWhere('achievements.id', 'like', '%' . $word . '%')
            ->paginate(25);
    }


    /**
     * @param null $category
     * @return mixed
     */   
    public static function getListByUser($category = null, $user_id)
    {
        if($category) { 
            if($category->parent == 0) {
               $subcategory_id  = 0;
               $category_id     = $category->id;
            } else {
               $subcategory_id  = $category->id;
               $category_id     = $category->parent;
            }          

            $results = DB::select('CALL getAchievementsSortByUser(?,?,?)',[$user_id,$category_id,$subcategory_id]);
            foreach($results as $key=>$result){

                if($result->criteria_value==0) $result->criteria_value=1;
                if(!empty($result->criteria_show)) $result->criteria_value=$result->criteria_show;
                $result->result=round($result->result);
                if($result->completed==1){
                    $result->percents = 100;
                }else{
                    $result->percents= $result->result<=0 ? 0 : round(($result->result/$result->criteria_value)*100);
                }
            }

            return $results;
        } else {
                $query = parent::select(
                    'achievements.title',
                    'achievements.points',
                    'achievements.icon',
                    'achievements.icon_grey',
                    'achievements.difficulty',
                    'achievements.criteria_text',
                    'achievements.created_at',
                    'achievements.criteria_value',
                    'achievements.criteria_show',
                    'cards.icon as icon_player_card',
                    'cards.icon_grey as icon_player_card_grey',
					'awards.icon_grey as icon_gear_grey',
					'awards.icon as icon_gear',
                     DB::RAW('1 as is_show'),
                     DB::RAW(" '1' as completed "),
                     DB::RAW("(SELECT DATE_FORMAT(files.start, '%m.%d.%Y') FROM achievements_users LEFT JOIN files ON files.id = achievements_users.file_id WHERE achievements_users.user_id = {$user_id} AND achievements_users.achievement_id = achievements.id ) as complete_date"),
                     DB::RAW(" '100' as percents ")
                    )
                    ->leftJoin('cards','cards.achievement_id','=','achievements.id')
                    ->leftJoin('awards','awards.achievement_id','=','achievements.id')
                    ->leftJoin('achievements_users','achievements_users.achievement_id','=','achievements.id')                               
                    ->where('achievements_users.user_id','=',$user_id)                                                   
                    ->orderBy('achievements_users.created_at','DESC');
            $results = $query->get();
            foreach($results as $key=>$result){
                if(!empty($result->criteria_show)) $result->criteria_value=$result->criteria_show;
                $result->result = $result->criteria_value;
                $result->percents= $result->result<=0 ? 0 : round(($result->result/$result->criteria_value)*100);
                $result->result=round($result->result);
            }
                return   $results;
        }

                

    }

    /**
     * @param null $category
     * @return mixed
     */
    public static function getListByUser3($category = null, $user_id)
    {
        if($category) {            
            $query =
            DB::table('achievements')
            ->select(
              'achievements.title',
              'achievements.points',
              'achievements.icon',
              'achievements.difficulty',
              'achievements.criteria_text',
              'cards.icon as icon_player_card',
              DB::RAW(" IF((SELECT user_id FROM achievements_users WHERE user_id = $user_id AND achievement_id = achievements.id ),1,0) as completed" ),
              DB::RAW("
                CASE IF((SELECT user_id FROM achievements_users WHERE user_id = $user_id AND achievement_id = achievements.id ),1,0) WHEN 1 THEN 100    
                ELSE 
                 CASE  achievements.criteria_id 
                   WHEN 10 THEN ROUND( ((SELECT COUNT(id) FROM rides where user_id = $user_id ) * 100 ) / achievements.criteria_value , 0 )   
                   WHEN 11 THEN CAST( ROUND( ((SELECT ROUND(SUM(total_distance)* 0.000621371192, 2) as total_distance FROM lap where user_id = $user_id ) * 100 ) / achievements.criteria_value , 2 ) AS UNSIGNED)    
                   WHEN 12 THEN CAST( ROUND( ((SELECT ROUND(MAX(total_distance)* 0.000621371192, 2) as total_distance FROM lap where user_id = $user_id ) * 100 ) / achievements.criteria_value , 0 ) AS UNSIGNED)       
                   WHEN 14 THEN 
                            CAST
                            ( 
                              ROUND
                              ( 
                                (
                                  (
                                        SELECT MAX(max_distance) as total_distance
                                        FROM (
                                            SELECT
                                              MAX(total_distance) as max_distance
                                            FROM
                                              lap
                                            WHERE user_id = $user_id
                                            GROUP BY
                                            WEEK(created_at)
                                        ) as subquery 
                                   ) * 100 
                                ) / achievements.criteria_value 
                              , 0 
                              ) 
                              AS UNSIGNED
                            )       
                    ELSE 0          
                 END
               END AS percents                
              ")  
            )
            ->leftJoin('cards','cards.achievement_id','=','achievements.id')
            ->leftJoin('achievements_users','achievements_users.achievement_id','=','achievements.id')          
                ->leftJoin('achievements_categories','achievements_categories.id','=','achievements.category_id')  
                ->leftJoin('achievements_criteria','achievements_criteria.id','=','achievements.criteria_id');  

            if($category->parent == 0 ) {
               $query->where('achievements.category_id','=',$category->id);
            } else {
                $query->where('achievements.subcategory_id','=',$category->id) ;                                          
            } 
            $query->groupBy('achievements.id')
                  ->orderByRaw(DB::raw("CAST(percents AS UNSIGNED) desc,`achievements`.`title` ASC"));    

            return $query->get();   

        } else {
                $query = parent::select(
                    'achievements.title',
                    'achievements.points',
                    'achievements.icon',
                    'achievements.difficulty',
                    'achievements.criteria_text',
                    'cards.icon as icon_player_card',
                     DB::RAW(" '1' as completed ")
                    )
                    ->leftJoin('cards','cards.achievement_id','=','achievements.id')
                    ->leftJoin('achievements_users','achievements_users.achievement_id','=','achievements.id')                               
                    ->where('achievements_users.user_id','=',$user_id)                                                   
                    ->orderBy('achievements_users.created_at','DESC');  
                return   $query->get();                                 
        }

                

    }


    /**
     * @param null $category
     * @return mixed
     */
    public static function getListByUser_withou_Proced($category = null, $user_id)
    {
        if($category) {
            // get completed by user
            $query1 = DB::table('achievements')->select(
                    'achievements.title',
                    'achievements.points',
                    'achievements.icon',
                    'achievements.difficulty',
                    'achievements.criteria_text',
                    'cards.icon as icon_player_card',
                     DB::RAW(" '1' as completed " ),
                     DB::RAW(" '100' as percents " )
                    )
                    ->leftJoin('cards','cards.achievement_id','=','achievements.id')
                    ->leftJoin('achievements_users','achievements_users.achievement_id','=','achievements.id')  
                    ->where('achievements_users.user_id','=',$user_id);
                    if($category->parent == 0 ) {
                        $query1->where('category_id','=',$category->id);
                        $query1->where('subcategory_id','=',0);
                    } else {
                        $query1->where('subcategory_id','=',$category->id) ;                                          
                    }
            // get not completed by user
            $query2 = DB::table('achievements')->select(
                    'achievements.title',
                    'achievements.points',
                    'achievements.icon',
                    'achievements.difficulty',
                    'achievements.criteria_text',
                    'cards.icon as icon_player_card',
                     DB::RAW(" '0' as completed " ),
                      DB::RAW(" '0' as percents " )
                    ) 
                    ->leftJoin('cards','cards.achievement_id','=','achievements.id')
                    ->leftJoin('achievements_users','achievements_users.achievement_id','=','achievements.id')                      
                    ->whereRAW(
                        'achievements.id NOT IN (SELECT au.achievement_id FROM achievements_users au WHERE au.user_id = ? )', [$user_id]
                    );                    
                    if($category->parent == 0 ) {
                        $query2->where('category_id','=',$category->id);
                        $query2->where('subcategory_id','=',0);
                    } else {
                        $query2->where('subcategory_id','=',$category->id) ;                                          
                    } 

            return $query1->union($query2)->get();                     

        } else {
                $query = parent::select(
                    'achievements.title',
                    'achievements.points',
                    'achievements.icon',
                    'achievements.difficulty',
                    'achievements.criteria_text',
                    'cards.icon as icon_player_card',
                     DB::RAW(" '1' as completed "),
                     DB::RAW(" '100' as percents " )
                    )
                    ->leftJoin('cards','cards.achievement_id','=','achievements.id')
                    ->leftJoin('achievements_users','achievements_users.achievement_id','=','achievements.id')                               
                    ->where('achievements_users.user_id','=',$user_id)                                                   
                    ->orderBy('achievements_users.created_at','DESC');  
                return   $query->get();                                 
        }

                

    }

    public static function getLocked($user_id)
    {
        return parent::select(
                            'achievements.*',
                            DB::RAW('COALESCE(cards.id,0) as cards_id'),
                            DB::RAW('COALESCE(awards.id,0) as gear_id')
                        )
                        ->leftJoin("cards","cards.achievement_id","=","achievements.id")
                        ->leftJoin("awards","awards.achievement_id","=","achievements.id")
                        ->whereRAW(
                            'achievements.id NOT IN (SELECT au.achievement_id FROM achievements_users au WHERE au.user_id = ? )', [$user_id]
                        )
                        ->get();
    }

    public static function getLockedFirst($user_id,$criteria=false)
    {
        $query = parent::select(
            'achievements.*',
            DB::RAW('COALESCE(cards.id,0) as cards_id'),
            DB::RAW('COALESCE(awards.id,0) as gear_id')
        )
            ->leftJoin("cards","cards.achievement_id","=","achievements.id")
            ->leftJoin("awards","awards.achievement_id","=","achievements.id")
            ->whereRAW(
                'achievements.id NOT IN (SELECT au.achievement_id FROM achievements_users au WHERE au.user_id = ? ) and achievements.criteria_id  = ?', [$user_id,$criteria]
            );

        return $query->first();
    }

}
