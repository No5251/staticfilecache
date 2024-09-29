<?php

declare(strict_types=1);

namespace SFC\Staticfilecache\Service;

use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;

class TypoScriptFrontendService
{
    /**
     * Get the tags and respect the configuration.
     */
    public function getTags(): array
    {
        $tsfe = $this->getTsfe();
        if (!($tsfe instanceof TypoScriptFrontendController)) {
            return [];
        }

        return array_unique((array) $tsfe->getPageCacheTags());
    }

    /**
     * Get the TSFE.
     *
     */
    protected function getTsfe(): ?TypoScriptFrontendController
    {
        return $GLOBALS['TSFE'];
    }
}
