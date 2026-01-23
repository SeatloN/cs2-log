<?php

namespace CSLog\CS2;

class LogPrefix
{
    public const UNIVERSAL = '^(?:L )?(?P<timestamp>\d{2}\/\d{2}\/\d{4} - \d{2}:\d{2}:\d{2}(?:\.\d{3})?)\s*(?::| - )\s+';

    public const CLASSIC =
        '^(?:L )?(?P<timestamp>\d{2}\/\d{2}\/\d{4} - \d{2}:\d{2}:\d{2}(?:\.\d{3})?):\s+';

    public const NEW =
        '^(?P<timestamp>\d{2}\/\d{2}\/\d{4} - \d{2}:\d{2}:\d{2}\.\d{3}) -\s+';
}
