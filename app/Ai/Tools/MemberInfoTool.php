<?php

namespace App\Ai\Tools;

use App\Models\Member;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Tools\Request;
use Stringable;

class MemberInfoTool implements Tool
{
    /**
     * Get the description of the tool's purpose.
     */
    public function description(): Stringable|string
    {
        return 'Looks up for member details by name or ID.';
    }

    /**
     * Execute the tool.
     */
    public function handle(Request $request): Stringable|string
    {
        $memberName = $request->string('member_name'); // extract from request

        $member = Member::where('name', 'like', "%{$memberName}%")->first();

        if (! $member) {
            return "Member '{$memberName}' not found.";
        }

        return "Member: {$member->name}, Status: {$member->status}";
    }

    /**
     * Get the tool's schema definition.
     */
    public function schema(JsonSchema $schema): array
    {
//        return [
//            'value' => $schema->string()->required(),
//        ];
        return [
            'member_name' => $schema->string()
                ->description('The member name to search for')
                ->required(),
        ];
    }
}
