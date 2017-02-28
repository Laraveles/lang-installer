<?php

namespace Laraveles\Lang\Installer\Console;

use GuzzleHttp\Client;
use RuntimeException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class AddCommand extends Command
{
    /**
     * Configure the command options.
     *
     * @return void
     */
    protected function configure()
    {
        $this->setName('generate')
            ->setDescription('Generate language files.');
    }
    /**
     * Execute the command.
     *
     * @param  InputInterface  $input
     * @param  OutputInterface  $output
     *
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->verifyLaravelApplication();

        $this->verifyFilesDoesntExist(
            $directory = getcwd().'/resources/lang/es'
        );

        $output->writeln('<info>Generating...</info>');

        $this->installLangDirectory($directory)
            ->download($directory);

        $output->writeln('<comment>Files ready!</comment>');
    }

    /**
     * Verify that we are in a Laravel application.
     *
     * @return void
     */
    protected function verifyLaravelApplication()
    {
        if (! file_exists(getcwd().'/public/index.php') || ! file_exists(getcwd().'/artisan')) {
            throw new RuntimeException('Seems you are not inside a Laravel application.');
        }
    }

    /**
     * Verify that the lang files does not already exist.
     *
     * @param  string $directory
     * @return void
     */
    protected function verifyFilesDoesntExist($directory)
    {
        foreach ($this->getFiles() as $file) {
            if (file_exists($directory.'/'.$file)) {
                throw new RuntimeException('File ['.$file.'] exists!');
            }
        }
    }

    /**
     * Install the lang directory.
     *
     * @param string $directory
     *
     * @return $this
     */
    protected function installLangDirectory($directory)
    {
        if (! is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        return $this;
    }

    /**
     * Download the necesary files to the given directory.
     *
     * @param string $directory
     *
     * @return $this
     */
    protected function download($directory)
    {
        foreach ($this->getFiles() as $file) {
            $response = (new Client)->get('https://raw.githubusercontent.com/Laraveles/lang-spanish/master/es/'.$file);

            file_put_contents(
                $directory.'/'.$file,
                $response->getBody()
            );
        }

        return $this;
    }

    /**
     * Get the lang files.
     *
     * @return array
     */
    protected function getFiles()
    {
        return [
            'auth.php',
            'pagination.php',
            'passwords.php',
            'validation.php',
        ];
    }
}
