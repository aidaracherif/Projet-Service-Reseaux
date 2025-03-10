<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TestFtpConnection extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:test-ftp-connection';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            $this->info("Tentative de connexion FTP...");
            $this->info("Host: " . config('filesystems.disks.ftp.host'));
            $this->info("Port: " . config('filesystems.disks.ftp.port') . " (type: " . gettype(config('filesystems.disks.ftp.port')) . ")");
            
            $directories = Storage::disk('ftp')->directories();
            $this->info('Connexion FTP réussie!');
            $this->info('Répertoires disponibles: ' . implode(', ', $directories));
            
            return Command::SUCCESS;
        } catch (\Exception $e) {
            $this->error('Erreur de connexion FTP: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }
}

