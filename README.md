## INTRODUCTION

The cwd_saml_mapping module is a module that used with drupal/saml_sp allows for the following

- Authentication through multiple IDP's ex. Cornell Test, Weill Test, Cornell Production Shibboleth
- Auto role assignment via a Saml Role Mapping config entity
- Configuration of which IDP to use in production (test or prod) and hooks all other non prod instance to test Shibboleth
- Future feature: to map saml data into Drupal user fields

## REQUIREMENTS

This module depends on the drupal/saml_sp module.

## INSTALLATION

TBD


## CONFIGURATION
- Enable the module as you would any other module
- Configure the global module settings: /admin/config/people/cwd-saml-mapping-config
- Configure the roles you want mapped: /admin/config/people/cwd-saml-mapping-config/saml-role-mapping
- Have a good day!

## MAINTAINERS

Current maintainers for Drupal 10:

- Bill Juda
