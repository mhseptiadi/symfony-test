<?php

namespace Console\Commands;

use Console\Services\ParseService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ParserCommand extends Command
{
    protected function configure()
    {
        $this->setName('jsonl-parse')
            ->setDescription('Parse a json file')
            ->setHelp('Parse a jsonl file from url')
            ->addOption(
                'url',
                'u',
                InputOption::VALUE_OPTIONAL,
                'Url where jsonl file comes from',
                'https://s3-ap-southeast-2.amazonaws.com/catch-code-challenge/challenge-1-in.jsonl'
            )
            ->addOption(
                'sort-field',
                'f',
                InputOption::VALUE_OPTIONAL,
                'Sorting the field',
                ''
            )
            ->addOption(
                'sort-direction',
                'd',
                InputOption::VALUE_OPTIONAL,
                'Sorting direction',
                'asc'
            )
            ->addOption(
                'save-as',
                's',
                InputOption::VALUE_OPTIONAL,
                'Save file as csv, xml or jsonl',
                'csv'
            )
            ->addOption(
                'email',
                'e',
                InputOption::VALUE_OPTIONAL,
                'Sending file to email',
                ''
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $url = $input->getOption('url');
        $field = $input->getOption('sort-field');
        $sort = $input->getOption('sort-direction');
        $email = $input->getOption('email');
        $save = $input->getOption('save-as');

        $parser = new ParseService();
        $parser->parse($url, $field, $sort, $save, $email);

        return Command::SUCCESS;
    }
}
