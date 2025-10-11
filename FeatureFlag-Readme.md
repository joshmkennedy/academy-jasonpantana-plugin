# Plan for creating a feature flag system

## Goals

- Have a way to put features behind a flag that can be toggled on and off for a given user role.
- Should have a easy way to check if a feature flag is enabled or not.
- if id is not set should fail open. 
```php
<?php
feature_flag('unknown-flag') == true;
```
build a simple check list table for feature flags and roles. for all features that are registered in a dedicated config
array stored in the codebase.
