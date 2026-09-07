# Changelog

All notable changes to this project are documented in this file.

## [1.2.0] - Unreleased

### Added

- Add checkout success order fallback for shops where the default `checkout.success` block is replaced but the request is still `checkout_onepage_success`.
- Add Outbrain and Google Ads server-side tracking settings (`ss_ob`, `ss_ga`).

### Fixed

- Fix PHP 8.4 nullable parameter deprecation in the config API.

## [1.1.1] - 2026-02-27

### Fixed

- Use Magento dynamic table names in customer order count and order index queries.

## [1.1.0] - 2024-09-17

### Added

- Add Admetrics meta API endpoint with Magento version, edition, and module setup versions.
- Add customer order count API endpoint.
- Add customer order index API endpoint.

### Fixed

- Fix SQL statement used to fetch customer order index data.

## [1.0.4] - 2024-09-02

### Changed

- Move tracking initialization to `head.additional` and append tracking scripts after DOM ready.
- Update Magento module dependencies.
- Stop committing `composer.lock` for the package.
- Improve installation and update documentation.

### Added

- Add CSP `connect-src` policy and v6 Admetrics domains.

## [1.0.3] - 2024-08-22

### Fixed

- Catch exceptions during pixel creation so tracking data generation does not break page rendering.

## [1.0.2] - 2024-08-22

### Fixed

- Use null-safe access during pixel creation to avoid compatibility issues.

## [1.0.1] - 2024-08-07

### Fixed

- Use the real Magento order entity ID for `oid`.
- Populate the public Magento order number in `on`.

## [1.0.0] - 2024-06-21

### Added

- Initial stable package release.

## [1.0.0-beta3] - 2024-06-20

### Fixed

- Store tracking-enabled config values as integers for Magento config writer compatibility.

## [1.0.0-beta2] - 2024-06-20

### Fixed

- Fix ACL resource name for the Admetrics config API.

## [1.0.0-beta1] - 2024-06-20

### Added

- Initial beta package with tracking pixel config API.
