<?php

namespace App\Command;

use App\Entity\Tournament;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Created by PhpStorm.
 * User: bermont
 * Date: 29/11/17
 * Time: 11:39
 */

class AppCreateTournamentCommand extends Command
{
    private $doctrine;

    protected static $defaultName = 'app:create-tournament';

    public function __construct(ManagerRegistry $doctrine)
    {
        parent::__construct();

        $this->doctrine = $doctrine;
    }

    protected function configure()
    {
        $this
            ->setDescription('Create a tournament')
            ->addArgument('name', inputArgument::REQUIRED, 'The tournament')
            ->addArgument('date', inputArgument::REQUIRED, 'The tournament');
    }

    protected  function execute(InputInterface $input, OutputInterface $output)
    {
        $name = $input->getArgument("name");
        $date = $input->getArgument("date");

        $tournament = new Tournament();
        $tournament->name = $name;
        $tournament->createdAt = new \DateTimeImmutable($date);

        $manager = $this->doctrine->getManager();
        $manager->persist($tournament);
        $manager->flush();

        $output->writeln(sprintf('Tournament: "%s" (%s) successfully added.', $name, $date));
    }
}