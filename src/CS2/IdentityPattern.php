<?php

namespace CSLog\CS2;

class IdentityPattern
{
    /**
     * Canonical CS2 identity block:
     *
     * "name<id><steam><team>"
     *
     * - name: lazy match, allows `<` inside username
     * - id: digits only
     * - steam: anything except `>`
     * - team: one of the four valid CS2 teams
     */
    public const BLOCK =
        '"(?P<name>.+?)<(?P<id>\d+)><(?P<steam>[^>]*)><(?P<team>CT|TERRORIST|Unassigned|Spectator)>"';

    /**
     * Same block but without named groups, for embedding inside other named groups.
     */
    public const BLOCK_INNER =
        '"(.+?)<\d+><[^>]*><(?:CT|TERRORIST|Unassigned|Spectator)>"';
}
