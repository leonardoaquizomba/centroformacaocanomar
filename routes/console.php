<?php

use Illuminate\Support\Facades\Schedule;

// Prune processed job batches older than 48 hours
Schedule::command('queue:prune-batches --hours=48')->daily();

// Prune failed jobs older than 7 days
Schedule::command('queue:prune-failed --hours=168')->weekly();
