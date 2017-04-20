<?php
namespace Medienreaktor\YamlTca\Slot;

/**
 * This file is part of the "yamltca" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

use Symfony\Component\Yaml\Yaml;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Slot for generating TCA from YAML files
 */
class YamlTcaSlot
{
    /**
     * Handles tcaIsBeingBuilt signal and returns TCA from YAML files
     *
     * @return array
     */
    public function handleTcaIsBeingBuilt($tca)
    {
        $packageManager = GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Package\\PackageManager');
        $activePackages = $packageManager->getActivePackages();

        foreach ($activePackages as $package) {
            $tcaConfigurationDirectory = $package->getPackagePath() . 'Configuration/TCA';
            $tcaOverridesPathForPackage = $package->getPackagePath() . 'Configuration/TCA/Overrides';

            $this->readTcaFromDirectory($tca, $tcaConfigurationDirectory);
            $this->readTcaFromDirectory($tca, $tcaOverridesPathForPackage, TRUE);
        }

        return [$tca];
    }

    /**
     * Reads TCA from YAML files and writes to $tca variable
     *
     * @param array $tca The current TCA array
     * @param string $tcaDirectory The directory to scan for YAML files
     * @param bool $override If files in directory are TCA overrides
     */
    private function readTcaFromDirectory(&$tca, $tcaDirectory, $override = FALSE)
    {
        if (is_dir($tcaDirectory)) {
            $files = scandir($tcaDirectory);
            foreach ($files as $file) {
                if (
                    is_file($tcaDirectory . '/' . $file)
                    && ($file !== '.')
                    && ($file !== '..')
                    && (substr($file, -5, 5) === '.yaml' || substr($file, -4, 4) === '.yml')
                ) {
                    $yaml = Yaml::parse(file_get_contents($tcaDirectory . '/' . $file));

                    if ($override) {
                        $tca = array_replace_recursive($tca, $yaml);
                    } else {
                        if (substr($file, -5, 5) === '.yaml') {
                            $tcaTableName = substr($file, 0, -5);
                        } else {
                            $tcaTableName = substr($file, 0, -4);
                        }
                        $tca[$tcaTableName] = $yaml[$tcaTableName];
                    }
                }
            }
        }
    }
}
