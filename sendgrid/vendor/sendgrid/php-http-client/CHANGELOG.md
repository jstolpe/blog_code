# Change Log
All notable changes to this project will be documented in this file.

This project adheres to [Semantic Versioning](http://semver.org/).

[2020-11-05] Version 3.13.0
---------------------------
**Library - Feature**
- [PR #101](https://github.com/sendgrid/php-http-client/pull/101): Allows for a user to utilize self-signed certificates. Thanks to [@davcpas1234](https://github.com/davcpas1234)!


[2020-10-14] Version 3.12.0
---------------------------
**Library - Feature**
- [PR #103](https://github.com/sendgrid/php-http-client/pull/103): Throw an InvalidRequest whenever a curl request fails. Thanks to [@colinodell](https://github.com/colinodell)!


[2020-08-19] Version 3.11.1
---------------------------
**Library - Docs**
- [PR #116](https://github.com/sendgrid/php-http-client/pull/116): Add first-timers.md for newcomers. Thanks to [@daniloff200](https://github.com/daniloff200)!

**Library - Chore**
- [PR #145](https://github.com/sendgrid/php-http-client/pull/145): update GitHub branch references to use HEAD. Thanks to [@thinkingserious](https://github.com/thinkingserious)!


[2020-07-22] Version 3.11.0
---------------------------
**Library - Test**
- [PR #120](https://github.com/sendgrid/php-http-client/pull/120): test enhancements. Thanks to [@peter279k](https://github.com/peter279k)!

**Library - Feature**
- [PR #109](https://github.com/sendgrid/php-http-client/pull/109): automatic code style checking. Thanks to [@misantron](https://github.com/misantron)!


[2020-06-24] Version 3.10.8
---------------------------
**Library - Fix**
- [PR #143](https://github.com/sendgrid/php-http-client/pull/143): Composer configuration, typos and type hints. Thanks to [@kampalex](https://github.com/kampalex)!


[2020-06-10] Version 3.10.7
---------------------------
**Library - Fix**
- [PR #144](https://github.com/sendgrid/php-http-client/pull/144): replace Throwable with Exception. Thanks to [@childish-sambino](https://github.com/childish-sambino)!


[2020-04-29] Version 3.10.6
---------------------------
**Library - Fix**
- [PR #141](https://github.com/sendgrid/php-http-client/pull/141): add the singular 'suppression' method. Thanks to [@childish-sambino](https://github.com/childish-sambino)!


[2020-03-18] Version 3.10.5
---------------------------
**Library - Docs**
- [PR #111](https://github.com/sendgrid/php-http-client/pull/111): run .md files through grammarly. Thanks to [@redbrickone](https://github.com/redbrickone)!


[2020-03-04] Version 3.10.4
---------------------------
**Library - Chore**
- [PR #140](https://github.com/sendgrid/php-http-client/pull/140): add PHP 7.4 to Travis and test with lowest dependencies. Thanks to [@childish-sambino](https://github.com/childish-sambino)!


[2020-02-19] Version 3.10.3
---------------------------
**Library - Fix**
- [PR #134](https://github.com/sendgrid/php-http-client/pull/134): Change contactsdb to marketing api #133. Thanks to [@murich](https://github.com/murich)!


[2020-01-22] Version 3.10.2
---------------------------
**Library - Docs**
- [PR #139](https://github.com/sendgrid/php-http-client/pull/139): baseline all the templated markdown docs. Thanks to [@childish-sambino](https://github.com/childish-sambino)!


[2020-01-09] Version 3.10.1
---------------------------
**Library - Chore**
- [PR #138](https://github.com/sendgrid/php-http-client/pull/138): prep the repo for automated releasing. Thanks to [@childish-sambino](https://github.com/childish-sambino)!
- [PR #135](https://github.com/sendgrid/php-http-client/pull/135): add more PHP versions to .travis.yml. Thanks to [@PaiizZ](https://github.com/PaiizZ)!

**Library - Docs**
- [PR #122](https://github.com/sendgrid/php-http-client/pull/122): fix grammar in Readme. Thanks to [@jmauerhan](https://github.com/jmauerhan)!


[2019-12-11] Version 3.10.0
---------------------------

**Library - Fix**
- [PR #99](https://github.com/sendgrid/php-http-client/pull/99): Throw InvalidRequest exception on invalid CURL request. Thanks to [@alextech](https://github.com/alextech)!

**Library - Docs**
- [PR #102](https://github.com/sendgrid/php-http-client/pull/102): Create a Use Cases Directory. Thanks to [@ProZsolt](https://github.com/ProZsolt)!
- [PR #106](https://github.com/sendgrid/php-http-client/pull/106): Only mention the lowest required PHP version in README. Thanks to [@svenluijten](https://github.com/svenluijten)!

## [3.9.6] - 2018-04-10
### Added
- PR [#98](https://github.com/sendgrid/php-http-client/pull/98). Updated documention of `Client.php` using PHPDoc.
- Thanks to [Martijn Melchers](https://github.com/martijnmelchers) for the pull request!

## [3.9.5] - 2018-03-26
### Added
- Fixes [#94](https://github.com/sendgrid/php-http-client/issues/94), PR [#95](https://github.com/sendgrid/php-http-client/pull/95): CreateCurlOptions method regression tests
- Thanks to [Alexandr Ivanov](https://github.com/misantron) for the pull request!

## [3.9.4] - 2018-03-22
### Fixed
- Fixes [#586](https://github.com/sendgrid/sendgrid-php/issues/586), PR [#96](https://github.com/sendgrid/php-http-client/pull/96): Fix constructor function signature regression.

## [3.9.3] - 2018-03-11
### Fixed
- Fixes [#584](https://github.com/sendgrid/sendgrid-php/issues/584), PR [#93](https://github.com/sendgrid/php-http-client/pull/93): Don't overwrite headers set from upstream dependencies.

## [3.9.2] - 2018-03-10
### Fixed
- Fixes [#12](https://github.com/sendgrid/php-http-client/issues/12), PR [#91](https://github.com/sendgrid/php-http-client/pull/91): Curl Options broken as array merge does not preserve keys. 

## [3.9.1] - 2018-03-09
### Fixed
- Fixes [#88](https://github.com/sendgrid/php-http-client/issues/88), PR [#89](https://github.com/sendgrid/php-http-client/pull/89): Restore missing function 'prepareResponse' due to bad previous merge. 

## [3.9.0] - 2018-03-08
### Added
- PR [#24](https://github.com/sendgrid/php-http-client/pull/24): implements sending concurrent requests with curl multi, thanks to [Tuan Nguyen](https://github.com/lightbringer1991) for the PR!
- PR [#25](https://github.com/sendgrid/php-http-client/pull/25): Add description how install php-http-client manually, thanks to [Ivan](https://github.com/janczer) for the PR!
- PR [#28](https://github.com/sendgrid/php-http-client/pull/28): Create code of conduct, thanks to [Alexander Androsyuk](https://github.com/alex2sat) for the PR!
- Closes [#32](https://github.com/sendgrid/php-http-client/issues/32), PR [#33](https://github.com/sendgrid/php-http-client/pull/33): Added TROUBLESHOOTING + Debug Info, thanks to [Braunson Yager](https://github.com/Braunson) for the PR!
- Closes [#35](https://github.com/sendgrid/php-http-client/issues/35), PR [#37](https://github.com/sendgrid/php-http-client/pull/37): Update README badges, thanks to [Tim Harshman](https://github.com/goteamtim) for the PR!
- Closes [#34](https://github.com/sendgrid/php-http-client/issues/34), PR [#38](https://github.com/sendgrid/php-http-client/pull/38): Update .md files with hyphen vs underscore for page links to enhance SEO, thanks to [Eric Kates](https://github.com/positronek) for the PR!
- Closes [#39](https://github.com/sendgrid/php-http-client/issues/39), PR [#40](https://github.com/sendgrid/php-http-client/pull/40): Added Packagist badge to README, thanks to [Rakshan Shetty](https://github.com/rakshans1) for the PR!
- PR [#41](https://github.com/sendgrid/php-http-client/pull/41): Add table of contents in README.md, thanks to [thepriefy](https://github.com/thepriefy) for the PR!
- PR [#42](https://github.com/sendgrid/php-http-client/pull/42): Add SendGrid logo at the top of README.md, thanks to [thepriefy](https://github.com/thepriefy) for the PR!
- PR [#43](https://github.com/sendgrid/php-http-client/pull/43): Add License section to the README.md, thanks to [thepriefy](https://github.com/thepriefy) for the PR!
- Closes [#46](https://github.com/sendgrid/php-http-client/issues/46), PR [#47](https://github.com/sendgrid/php-http-client/pull/47): Create Pull Request Template, thanks to [Paweł Lewtak](https://github.com/pawel-lewtak) for the PR!
- Closes [#48](https://github.com/sendgrid/php-http-client/issues/48), PR [#51](https://github.com/sendgrid/php-http-client/pull/51): Added example file, updated .gitignore and README, thanks to [Diego Rocha](https://github.com/dhsrocha) for the PR!
- PR [#53](https://github.com/sendgrid/php-http-client/pull/53): README and usage example update, thanks to [Alexandr Ivanov](https://github.com/misantron) for the PR!
- PR [#55](https://github.com/sendgrid/php-http-client/pull/55): Code climate config, thanks to [Alexandr Ivanov](https://github.com/misantron) for the PR!
- Closes [#58](https://github.com/sendgrid/php-http-client/pull/58), PR [#60](https://github.com/sendgrid/php-http-client/pull/60): Adds unit test for checking file existence in repo, thanks to [Michele Orselli](https://github.com/micheleorselli) for the PR!
- Closes [#57](https://github.com/sendgrid/php-http-client/pull/57), PR [#61](https://github.com/sendgrid/php-http-client/pull/61): Adds unit test for checking year on licence, thanks to [Michele Orselli](https://github.com/micheleorselli) for the PR!
- Closes [#50](https://github.com/sendgrid/php-http-client/issues/50), PR [#62](https://github.com/sendgrid/php-http-client/pull/62): Create USAGE.md, thanks to [Nitanshu](https://github.com/nvzard) for the PR!
- Closes [#57](https://github.com/sendgrid/php-http-client/issues/57), PR [#66](https://github.com/sendgrid/php-http-client/pull/66): Add unit test for license year, thanks to [Alex](https://github.com/pushkyn) for the PR!
- Closes [#67](https://github.com/sendgrid/php-http-client/issues/67), PR [#68](https://github.com/sendgrid/php-http-client/pull/68): Add CodeCov support to .travis.yml, thanks to [Manjiri Tapaswi](https://github.com/mptap) for the PR!
- Closes [#49](https://github.com/sendgrid/php-http-client/issues/49), PR [#73](https://github.com/sendgrid/php-http-client/pull/73): Create Dockerfile, thanks to [Jessica Mauerhan](https://github.com/jmauerhan) for the PR!
- Closes [#76](https://github.com/sendgrid/php-http-client/issues/76), PR [#78](https://github.com/sendgrid/php-http-client/pull/78): Added Pull Requests Review section to CONTRIBUTE.md Closes, thanks to [Povilas Balzaravičius](https://github.com/Pawka) for the PR!
- Closes [#63](https://github.com/sendgrid/php-http-client/issues/63), PR [#79](https://github.com/sendgrid/php-http-client/pull/79): Refactor makeRequest method, thanks to [Michael Dennis](https://github.com/michaeljdennis) for the PR!
- PR [#82](https://github.com/sendgrid/php-http-client/pull/82): Add JsonSerializable type to phpDoc of $body parameter in makeRequest method, thanks to [Jan Konáš](https://github.com/jankonas) for the PR!
- PR [#85](https://github.com/sendgrid/php-http-client/pull/85): Updated the PHP Version details, thanks to [Siddhant Sharma](https://github.com/ssiddhantsharma) for the PR!
- PR [#86](https://github.com/sendgrid/php-http-client/pull/86): Add phpdoc for send method, thanks to [Vitaliy Ryaboy](https://github.com/rvitaliy) for the PR!
- PR [#84](https://github.com/sendgrid/php-http-client/pull/84): Update Docker instructions


### Fixed
- PR [#26](https://github.com/sendgrid/php-http-client/pull/26): README typo, thanks to [Cícero Pablo](https://github.com/ciceropablo) for the PR!
- PR [#30](https://github.com/sendgrid/php-http-client/pull/30), Fixes [#18](https://github.com/sendgrid/php-http-client/issues/18): Disable CURLOPT_FAILONERROR, thanks to [Zsolt Prontvai](https://github.com/ProZsolt) for the PR!
- PR [#44](https://github.com/sendgrid/php-http-client/pull/44): Fix Typo and add missing links to README, thanks to [Alex](https://github.com/pushkyn) for the PR!
- PR [#52](https://github.com/sendgrid/php-http-client/pull/52): Fix syntax errors in README examples, thanks to [Michael Spiss](https://github.com/michaelspiss) for the PR!
- Fixes [#56](https://github.com/sendgrid/php-http-client/pull/56), PR [#59](https://github.com/sendgrid/php-http-client/pull/59): Update LICENSE - fix year, thanks to [Alex](https://github.com/pushkyn) for the PR!
- PR [#69](https://github.com/sendgrid/php-http-client/pull/69): Remove extra parenthesis from README, thanks to [Jessica Mauerhan](https://github.com/jmauerhan) for the PR!
- PR [#71](https://github.com/sendgrid/php-http-client/pull/71): Fix typo in CONTRIBUTING.md, thanks to [thepriefy](https://github.com/thepriefy) for the PR!
- Fixes [#81](https://github.com/sendgrid/php-http-client/issues/81), PR [#87](https://github.com/sendgrid/php-http-client/pull/87): Stop using insecure option by default 

## [3.8.0] - 2017-09-13
### Added
- Pull request #23: [Automatically retry when rate limit is reached](https://github.com/sendgrid/php-http-client/pull/23)
- Thanks to [Budi Chandra](https://github.com/budirec) for the pull request!

## [3.7.0] - 2017-05-04
### Added
- Pull request #19: [Added ability to get headers as associative array](https://github.com/sendgrid/php-http-client/pull/19)
- Solves issue #361: [https://github.com/sendgrid/sendgrid-php/issues/361](https://github.com/sendgrid/sendgrid-php/issues/361)
- Thanks to [Alexander](https://github.com/mazanax) for the pull request!

## [3.6.0] - 2017-03-01
### Added
- Pull request #16: [Pass the curlOptions to the client in buildClient](https://github.com/sendgrid/php-http-client/pull/16)
- Thanks to [Baptiste Clavié](https://github.com/Taluu) for the pull request!

## [3.5.1] - 2016-11-17
### Fixed
- Pull request #13, fixed issue #12: [Change from to php union operator to combine curl options](https://github.com/sendgrid/php-http-client/pull/13)
- Thanks to [emil](https://github.com/emilva) for the pull request!

## [3.5.0] - 2016-10-18
### Added
- Pull request #11: [Added curlOptions property to customize curl instance](https://github.com/sendgrid/php-http-client/pull/11)
- Thanks to [Alain Tiemblo](https://github.com/ninsuo) for the pull request!

## [3.4.0] - 2016-09-27
### Added
- Pull request #9: [Add getters for certain properties](https://github.com/sendgrid/php-http-client/pull/9)
- Thanks to [Arjan Keeman](https://github.com/akeeman) for the pull request!

## [3.3.0] - 2016-09-13
### Added
- Pull request #6: [Library refactoring around PSR-2 / PSR-4 code standards](https://github.com/sendgrid/php-http-client/pull/6)
- Thanks to [Alexandr Ivanov](https://github.com/misantron) for the pull request!

## [3.1.0] - 2016-06-10
### Added
- Automatically add Content-Type: application/json when there is a request body

## [3.0.0] - 2016-06-06
### Changed
- Made the Request and Response variables non-redundant. e.g. request.requestBody becomes request.body

## [2.0.2] - 2016-02-29
### Fixed
- Renaming files to conform to PSR-0, git ignored the case in 2.0.1

## [2.0.1] - 2016-02-29
### Fixed
- Renaming files to conform to PSR-0

## [1.0.1] - 2016-02-29
### Fixed
- Composer/Packagist install issues resolved

## [1.0.0] - 2016-02-29
### Added
- We are live!
