<?php

namespace App\Ai\Agents;

use App\Ai\Tools\DatabaseQueryTool;
use App\Ai\Tools\MemberInfoTool;
use Laravel\Ai\Concerns\RemembersConversations;
use Laravel\Ai\Contracts\Agent;
use Laravel\Ai\Contracts\Conversational;
use Laravel\Ai\Contracts\HasTools;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Messages\Message;
use Laravel\Ai\Promptable;
use Stringable;
use Illuminate\Support\Facades\DB;
class AiAgent implements Agent, Conversational, HasTools
{
    use Promptable, RemembersConversations;

    /**
     * Get the instructions that the agent should follow.
     */
    protected string $provider="groq";
    protected string $model= "llama-3.3-70b-versatile";
    public function instructions(): Stringable|string
    {
        $tables = DB::select("SELECT table_name FROM information_schema.tables WHERE table_schema = DATABASE()");
        $schema = collect($tables)->map(function ($table) {
            $tableName = $table->table_name ?? $table->TABLE_NAME;
            $columns   = DB::select("DESCRIBE `{$tableName}`");
            $cols      = collect($columns)->pluck('Field')->join(', ');
            return "{$tableName}: ({$cols})";
        })->join("\n");

        return "
        {$schema}

        Rules:
        - Always use DatabaseQueryTool to fetch real data before answering.
        - Only write SELECT queries — never mutate data.
        - Use JOINs when data spans multiple tables.
        - Format responses clearly using markdown tables.
        - Never guess or invent data.
    ";
    }

    /**
     * Get the list of messages comprising the conversation so far.
     *
     * @return Message[]
     */
    public function messages(): iterable
    {
        return [];
    }

    /**
     * Get the tools available to the agent.
     *
     * @return Tool[]
     */
    public function tools(): iterable
    {
        return [
            new DatabaseQueryTool(),
            new MemberInfoTool()
        ];
    }
}
