<?php
/**
 * @file
 * Contains \Drupal\AppConsole\Generator\AuthenticationProviderGenerator.
 */

namespace Drupal\AppConsole\Generator;

class AuthenticationProviderGenerator extends Generator
{
    /**
     * Generator Plugin Block
     * @param  $module
     * @param  $class_name
     */
    public function generate($module, $class_name, $provider_id)
    {
        $parameters = [
          'module' => $module,
          'class_name' => $class_name
        ];

        $this->renderFile(
          'module/src/Authentication/Provider/authentication-provider.php.twig',
          $this->getAuthenticationPath($module, 'Provider') . '/' . $class_name . '.php',
          $parameters
        );


        $parameters = [
          'module' => $module,
          'class_name' => 'Authentication\\Provider\\' . $class_name,
          'service_name' => 'authentication.' . $module,
          'services' => [
            ['name' => 'config.factory'],
            ['name' => 'entity.manager']
          ],
          'file_exists' => file_exists($this->getModulePath($module) . '/' . $module . '.services.yml'),
          'tags' => [
            'name' => 'authentication_provider',
            'provider_id' => $provider_id,
            'priority' => '100'
          ],
        ];

        $this->renderFile(
          'module/services.yml.twig',
          $this->getModulePath($module) . '/' . $module . '.services.yml',
          $parameters,
          FILE_APPEND
        );
    }
}
