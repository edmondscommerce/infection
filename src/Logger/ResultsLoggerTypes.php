<?php
/**
 * Copyright © 2017-2018 Maks Rafalko
 *
 * License: https://opensource.org/licenses/BSD-3-Clause New BSD License
 */

declare(strict_types=1);

namespace Infection\Logger;

/**
 * @internal
 */
final class ResultsLoggerTypes
{
    const TEXT_FILE = 'text';
    const SUMMARY_FILE = 'summary';
    const DEBUG_FILE = 'debug';
    const BADGE = 'badge';
    const PER_MUTATOR = 'perMutator';

    const ALL = [
        self::TEXT_FILE,
        self::DEBUG_FILE,
        self::SUMMARY_FILE,
        self::BADGE,
        self::PER_MUTATOR,
    ];

    const ALLOWED_WITHOUT_LOGGING = [
        self::BADGE,
    ];
}
