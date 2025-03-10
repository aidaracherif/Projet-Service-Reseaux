<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class IRedMailService
{
    protected $sshUser = "soxnadiarra"; // Remplace par ton utilisateur Debian
    protected $sshHost = "192.168.1.11"; // L'IP de ta VM
    protected $scriptPath = "/usr/bin/iredmail_accounts.sh"; // Le chemin sur la VM

    /**
     * Exécute une commande SSH à distance
     */
    private function executeRemoteCommand($command)
    {
        $fullCommand = "ssh {$this->sshUser}@{$this->sshHost} '{$command}'";
        Log::info("Exécution de la commande SSH : {$fullCommand}");

        $output = shell_exec($fullCommand);
        
        Log::info("Résultat de la commande : {$output}");

        return $output;
    }

    /**
     * Crée un compte email
     */
    public function createMailbox($username, $password)
    {
        $email = "{$username}@mail.smarttec.sn";
        
        $escapedPassword = escapeshellarg($password);
        $command = "ssh soxnadiarra@192.168.1.11 sudo /usr/bin/iredmail_accounts.sh create $username mail.smarttec.sn motdepasse $escapedPassword";

        
        Log::info("Exécution de la commande : {$command}");
        $output = shell_exec($command);
        
        if (strpos($output, "SUCCESS") !== false) {
            Log::info("Compte email créé avec succès : {$email}");
            return true;
        } else {
            Log::error("Échec de création du compte email : {$output}");
            return false;
        }
    }


    /**
     * Supprime un compte email
     */
    public function deleteMailbox($username)
    {
        $email = "{$username}@mail.smarttec.sn";
        $command = "sudo {$this->scriptPath} delete {$username} mail.smarttec.sn";

        $output = $this->executeRemoteCommand($command);

        if (strpos($output, "SUCCESS") !== false) {
            Log::info("Compte email supprimé avec succès : {$email}");
            return true;
        } else {
            Log::error("Échec de suppression du compte email : {$output}");
            return false;
        }
    }

    /**
     * Met à jour le mot de passe d'un compte email
     */
    public function updatePassword($username, $newPassword)
    {
        $email = "{$username}@mail.smarttec.sn";
        $command = "sudo {$this->scriptPath} password {$username} password={$newPassword}";

        $output = $this->executeRemoteCommand($command);

        if (strpos($output, "SUCCESS") !== false) {
            Log::info("Mot de passe mis à jour avec succès pour {$email}");
            return true;
        } else {
            Log::error("Échec de mise à jour du mot de passe : {$output}");
            return false;
        }
    }
}
