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

    /**
     * Constructor.
     *
     * @param string|null $name The name of the command; passing null means it must be set in configure()
     *
     * @throws LogicException When the command name is empty
     */
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
            ->addArgument('password', InputArgument::REQUIRED, 'Password')
        ;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $email = $input->getArgument('email');
        $password = $input->getArgument('password');
//        $manager = $this->getContainer()->get('wcadmin_user_manager');
        $manager = $this->userManager;
        $user = $manager->createUser($email, $password);
        $output->writeln(sprintf('User %s created', $user->getUsername()));

        return 0;
    }
}
