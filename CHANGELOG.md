# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/en/1.0.0/)
and this project adheres to [Semantic Versioning](http://semver.org/spec/v2.0.0.html).

## 4.0.0
### Changed
- Min PHP version is 8.3
- Return an empty string if an empty string was provided
- [internal] PHPUnit was updated to ^12.5
- [internal] Installed PHPStan

## 3.0.0
### Changed
- Min PHP version is 8.2

## [2.1.0] - 2017-05-05
### Added
- Framework agnostic support
- Update Readme.MD
- Support PHP 7.1
### Changed
- Rename repository
- Change properties and methods visibility
- Rename methods:
    - `setHeaderLinks` to `headerLinks`
    - `arrayTableContents` to `tableContents`
    - `str_replace_first` to `replaceFirstOccurrence`
### Removed
- Support PHP 5.6

## [2.0.0] - 2017-04-08
### Changed
- Rename repository
- Change properties and methods visibility
- Rename methods:
    - `setHeaderLinks` to `headerLinks`
    - `arrayTableContents` to `tableContents`
    - `str_replace_first` to `replaceFirstOccurrence`

## [1.0.0] - 2017-03-30
### Added
- The ability to generate table of contents
- Create README.MD 