<?php

namespace AlexWestergaard\PhpGa4\Facade\Type;

interface Ga4Exception
{
    const MICROTIME_INVALID_FORMAT = 101001;
    const MICROTIME_EXPIRED = 101002;

    const PARAM_MISSING_REQUIRED = 102001;
    const PARAM_RESERVED = 102002;
    const PARAM_TOO_LONG = 102003;

    const EVENT_NAME_RESERVED = 103001;
    const EVENT_NAME_MISSING = 103002;
    const EVENT_NAME_TOO_LONG = 103003;
    const EVENT_NAME_INVALID = 103004;

    const REQUEST_TOO_LARGE = 104001;
    const REQUEST_WRONG_RESPONSE_CODE = 104002;
    const REQUEST_EMPTY_RESPONSE = 104003;
    const REQUEST_INVALID_RESPONSE = 104004;
    const REQUEST_INVALID_BODY = 104005;
    const REQUEST_MISSING_MEASUREMENT_ID = 104006;
    const REQUEST_MISSING_API_SECRET = 104007;
}
