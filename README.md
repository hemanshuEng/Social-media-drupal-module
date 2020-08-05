#Social Media Block    
###plugin
####Description
Add social media link , choose icon and layout of block

###Docker container for development

####Docker for drupal
https://github.com/mogtofu33/docker-compose-drupal

- docker has mysql, xdebug, drupal console etc...
#### Requirements

- [Docker engine 18+](https://docs.docker.com/install)
- [Docker compose 1.24+](https://docs.docker.com/compose/install)

**Recommended**

- [Composer](https://getcomposer.org)

##Setup

- clone
  ```
  git clone https://github.com/mogtofu33/docker-compose-drupal
  ```
- cd into docker-compose-drupal
  ```
  cd docker-compose-drupal
  ```
- Create new Project
  ```
  composer create-project drupal-composer/drupal-project:8.x-dev some-dir --no-interaction
  ```
- setup docker configuration
  ```
  make setup
  ```
- run docker container
   ```
   make up
   ```
- setup drupal site and follow instruction
  https://localhost
- note : for database use hostname: mysql (not localhost)

## disabling cache for development
-  copy drupal\sites\example.setting.local.php to drupal\site\default\setting.local.php
-  uncomment \sites\settings.php following session
    ```
      if (file_exists($app_root . '/' . $site_path . '/settings.local.php')) {
          include $app_root . '/' . $site_path . '/settings.local.php';
      }
    ```
 - add this to drupal\sites\development.sevices.yml
    ```yaml
       parameters:
         http.response.debug_cacheability_headers: true
         twig.config:
           debug: true
           auto_reload: true
           cache : true
    ```
 - uncomment in drupal\sites\settting.local.php
  ```
    $settings['cache']['bins']['dynamic_page_cache'] = 'cache.backend.null';
    $settings['cache']['bins']['page'] = 'cache.backend.null';
    $settings['cache']['bins']['render'] = 'cache.backend.null';
  ```
 - you can add devel plugin and webprofile for debug
