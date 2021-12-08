<?php

namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsCommand(
    name: 'app:create-user',
    description: 'Create new user manually',
)]
class CreateUserCommand extends Command
{
    private EntityManagerInterface $em;
    private UserPasswordHasherInterface $hasher;

    public function __construct(EntityManagerInterface $entityManager, UserPasswordHasherInterface $hasher)
    {
        $this->em = $entityManager;
        $this->hasher = $hasher;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('username', InputArgument::OPTIONAL, 'Username for new user')
            ->addArgument('password', InputArgument::OPTIONAL, 'Password for new user')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $username = $input->getArgument('username');
        $password = $input->getArgument('password');
        $helper = $this->getHelper('question');

        $output->writeln([
            '<info>Manual User Creator</info>',
            '<comment>=====================</comment>',
        ]);

        if (!$username) {
            $output->writeln([
                '<info>Enter username (e.g. <comment>admin</comment>)</info>',
            ]);
            $nameQuestion = new Question('<comment>Username: </comment>');
            $username = $helper->ask($input, $output, $nameQuestion);
        }
        if (!$password) {
            $output->writeln([
                '<info>Enter password</info>',
            ]);
            $passwordQuestion = new Question('<comment>Password: </comment>');
            $passwordQuestion->setHidden(true);
            $password = $helper->ask($input, $output, $passwordQuestion);
        }
        $output->writeln([
            '<info>Choose user role (<comment>default: ROLE_USER</comment>)</info>',
        ]);
        $roleQuestion = new ChoiceQuestion('<comment>Role number: </comment>', [User::ROLE_USER, User::ROLE_MODERATOR, User::ROLE_ADMIN], 0);
        $role = $helper->ask($input, $output, $roleQuestion);

        if ($username && $password && $role){
            $user = new User();
            $user->setUsername($username);
            $user->setPassword($this->hasher->hashPassword($user, $password));
            $currRole = $user->getRoles();
            $currRole[] = $role;
            $user->setRoles(array_unique($currRole));

            $this->em->persist($user);
            $this->em->flush();

            $io->success('User successfully created!');
            return Command::SUCCESS;
        }


        $io->warning('Something went wrong! Please try again!');
        return Command::FAILURE;
    }
}
