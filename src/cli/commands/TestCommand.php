<?php
namespace Mimicry\Cli\Commands;

use Mimicry\Cli\Handlers\CreateService;
use Mimicry\Foundation\App;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Command\LockableTrait;

class TestCommand extends Command {

    use LockableTrait;

    private $app = null;

    protected static $defaultName = 'make:service';


    public function __construct(App $app)
    {
        $this->app = $app;

        parent::__construct();
    }


    protected function configure()
    {
        $this
            ->setDescription('Creates a new user.')
            ->setHelp('This command allows you to create a user...')
            ->addArgument('name', InputArgument::REQUIRED, 'Name of the template to create')
            ->addOption(
                'init',
                'i',
                InputOption::VALUE_OPTIONAL,
                'Include a _init method',
                false
            )
            ->addOption(
                'register',
                'r',
                InputOption::VALUE_OPTIONAL,
                'Include a _register method',
                false
            );;
    }


    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if (!$this->lock()) {
            $output->writeln('The command is already running in another process.');
            return 0;
        }

        $handler = $this->app->make(CreateService::class);
        $responce = $handler->init($input->getArguments(), $input->getOptions());

        if ($responce) {
            $output->writeln([
                $responce,
            ]);
        } else {
            $output->writeln([
                'Template "' . $input->getArgument('name') . '" created.',
                ($input->getOption('init') !== false ? "An _init method was added." : "The _init method was omitted."),
                ($input->getOption('register') !== false ? "An _register method was added." : "The _register method was omitted."),
                ''
            ]);
        }

        $this->release();

        return 0;
    }

}