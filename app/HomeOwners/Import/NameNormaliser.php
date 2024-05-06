<?php

namespace App\HomeOwners\Import;

use Illuminate\Support\Collection;

class NameNormaliser
{
    /**
     * @return Collection<int, array<string, string|null>>
     */
    public function normalise(string $str): Collection
    {
        $normalisedNames = new Collection();

        /** @var array<int, string> $names */
        $names = preg_split('/ (\&|and|\+) /', $str);

        for ($i = 0; $i < count($names); $i++) {
            /** @var string $name */
            $name = preg_replace('/[^A-Za-z- ]/', '', $names[$i]);

            $parts = explode(' ', $name);

            // If the current name contains only one part, borrow the
            // first & last names from the next name (where present).
            if (count($parts) === 1 && isset($names[$i + 1]) && count($nextName = explode(' ', $names[$i + 1])) > 1) {
                $parts[1] = $nextName[1];

                if (isset($nextName[2])) {
                    $parts[2] = $nextName[2];
                    unset($nextName[1]);
                }
                $names[$i + 1] = implode(' ', $nextName);
            }

            if (count($parts) === 2) {
                $firstName = null;
                $initial = null;
                $lastName = $parts[1];
            } else {
                $firstName = strlen($parts[1]) === 1 ? null : $parts[1];
                $initial = strlen($parts[1]) === 1 ? $parts[1] : null;
                $lastName = $parts[2];
            }

            $normalisedNames->push([
                'title' => $parts[0],
                'first_name' => $firstName,
                'initial' => $initial,
                'last_name' => $lastName,
            ]);
        }

        return $normalisedNames;
    }
}
