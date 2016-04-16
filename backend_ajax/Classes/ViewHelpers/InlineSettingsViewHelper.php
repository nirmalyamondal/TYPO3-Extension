<?php

namespace TYPO3\BackendAjax\ViewHelpers;

/***************************************************************
 *  Copyright notice
 *
 *  (c) sgalinski Internet Services (http://www.sgalinski.de)
 *
 *  All rights reserved
 *
 *  This script is part of the AY project. The AY project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * Inline settings ViewHelper
 *
 * Example:
 * {namespace vh=TYPO3\BackendAjax\ViewHelpers}
 * <vh:inlineSettings settings="{settings}" />
 */
class InlineSettingsViewHelper extends AbstractViewHelper {
    /**
     * Renders inline javascript settings
     *
     * @param array $settings
     * @return string
     */
    public function render(array $settings) {
        $extensionName = $this->controllerContext->getRequest()->getControllerExtensionName();

        return '
			<script type="text/javascript">
			var NM = NM || {};
			NM.settings = NM.settings || {};
			NM.settings.' . $extensionName . ' = NM.settings.' . $extensionName . ' || {};
			var languageLabels = ' . json_encode($settings) . ';
			for (label in languageLabels) {
				NM.settings.' . $extensionName . '[label] = languageLabels[label];
			}
			</script>
		';
    }
}

?>
