<?php

namespace Modules\Common\Utils;

final class RegexProvider
{
    public function youtubeVideo(): string
    {
        return '/^(http(s)?:\/\/)?((w){3}.)?youtu(be|.be)?(\.com)?\/.+/';
    }
}
