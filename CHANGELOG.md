# Changelog

All notable changes to this project will be documented in this file, in reverse chronological order by release.

## 0.3.0

### Added

- Support for Symfony 8, scheb/2fa-bundle 8 and Sylius 2.3

### Deprecated

- Nothing.

### Removed

- Support for PHP 8.2
- Behat/Mink development dependencies (unused, not compatible with Symfony 8)

### Fixed

- Add missing native return types required by Symfony 8
- Service definitions are now loaded from YAML instead of XML (`XmlFileLoader` was removed in Symfony 8)

## 0.2.1

### Added

- Nothing.

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- [#16](https://github.com/bitExpert/sylius-2fa/pull/16) Fix null initialize error

## 0.2.0

### Added

- [#13](https://github.com/bitExpert/sylius-2fa/pull/13) add functionality to disable 2FA
- [#10](https://github.com/bitExpert/sylius-2fa/pull/10) Notify email for customer when 2FA is successfully enabled

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- [#9](https://github.com/bitExpert/sylius-2fa/pull/9) prevent AccessDenied Exception when choosing email 2FA type

## 0.1.1

### Added

- Nothing.

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- [#2](https://github.com/bitExpert/sylius-2fa/pull/2) TASK: adjust formating of title template add missing translations

## 0.1.0

Initial release.
