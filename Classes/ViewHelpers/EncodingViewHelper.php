<?php
namespace FKU\FkuLibrary\ViewHelpers;
/***************************************************************
*  Copyright notice
*
*  (c) 2015 Daniel Widmer <daniel.widmer@fku.ch>
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
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

/**
*
* @package fku_library
*/

use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;

class EncodingViewHelper extends AbstractViewHelper {

	use CompileWithRenderStatic;

    public function initializeArguments() {
        $this->registerArgument('to', 'string', 'target encoding', true);
        $this->registerArgument('from', 'string', 'actual encoding', false, NULL);
	}

    /**
     * @param array $arguments
     * @param \Closure $renderChildrenClosure
     * @param RenderingContextInterface $renderingContext
     * @return string
     */
	public static function renderStatic(array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext) {

		$content = $renderChildrenClosure;
		return mb_convert_encoding($content, $to, $from);
//		return mb_convert_encoding($content, 'UTF-16', 'UTF-8');
	}
}
?>