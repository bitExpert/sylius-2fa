# UPGRADE

## 0.2.x to 0.3.0

- The minimum PHP version is now 8.3 (8.4 is required when installing scheb/2fa-bundle 8 or Symfony 8).
- The plugin supports scheb/2fa-bundle 7.13+ and 8.x. The `scheb/2fa-*` packages must all be on the same major version.
- scheb/2fa-bundle 8 changes the priority of the two-factor authenticator from `0` to `-100`. If you register custom authenticators on the `admin` or `shop` firewalls, check that the order is still what you expect.
- The plugin service definitions moved from `config/services*.xml` to `config/services*.yaml` (the XML loader was removed in Symfony 8). Nothing to do unless you imported those files directly.
