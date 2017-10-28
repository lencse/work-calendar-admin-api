<?php

namespace AppBundle\Command;

use AppBundle\Auth\UserManager;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateUserCommand extends ContainerAwareCommand
{

    /**
     * @var UserManager
     */
    private $userManager;

    public function __construct($name = null, UserManager $userManager)
    {
        $this->userManager = $userManager;
        parent::__construct($name);
    }

    protected function configure(): void
    {
        $this
            ->setName('user:create')
            ->setDescription('Creates a user')
            ->addArgument('email', InputArgument::REQUIRED, 'Email')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $email = $input->getArgument('email');
        $user = $this->userManager->createUser($email);
        $output->writeln(sprintf('User %s created', $user->getEmail()));
        return 0;
    }
}
