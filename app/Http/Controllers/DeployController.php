<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\Process\Process;

class DeployController extends Controller
{
    public function deploy(Request $request)
    {
        // Print base path for verification (optional)
        // echo 'Base path: ' . base_path() . PHP_EOL;

        $githubPayload = $request->getContent();
        $githubHash = $request->header('X-Hub-Signature');
        $localToken = config('app.deploy_secret');
        $localHash = 'sha1=' . hash_hmac('sha1', $githubPayload, $localToken, false);

        // Log request details and signature verification
        Log::info('Deployment request received:', [
            'github_payload' => $githubPayload, // (optional, masked if sensitive)
            'github_hash' => $githubHash,
            'local_hash' => $localHash,
        ]);

        if (hash_equals($githubHash, $localHash)) {
            $root_path = base_path();
            $process = new Process('cd ' . $root_path . '; ./deploy.sh');

            // Log command execution start
            Log::info('Executing deployment script...');

            $process->run(function ($type, $buffer) use ($process) {
                echo $buffer; // Optional: Display output in real-time

                // Log command output line by line
                Log::debug($buffer);
            });

            // Log command execution completion
            Log::info('Deployment script execution finished with exit code: ' . $process->getExitCode());
        } else {
            Log::error('Invalid deployment request: Signature mismatch.');
        }
    }
}


