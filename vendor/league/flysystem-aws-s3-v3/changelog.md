# Changelog

## 1.0.6 - 2015-09-25

### Fixed

* The `has` operation now respects path prefix, bug introduced in 1.0.5.

## 1.0.5 - 2015-09-22

### Fixed

* `has` calls now use `doesObjectExist` rather than retrieving metadata.

## 1.0.4 - 2015-07-06

### Fixed

* Fixed delete return value.

## 1.0.3 - 2015-06-16

### Fixed

* Use an iterator for contents listing to break through the 1000 objects limit.

## 1.0.2 - 2015-06-06

### Fixed

* Exception due to misconfiguration no longer causes a fatal error but are properly rethrown.

## 1.0.1 - 2015-05-31

### Fixed

* Stable release depending in the first v3 release of the AWS SDK.