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
                's',
                InputOption::VALUE_OPTIONAL,
                'Sorting the field',
                'asc'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $url = $input->getOption('url');
        $field = $input->getOption('sort-field');
        $sort = $input->getOption('sort-direction');

        $parser = new ParseService();
        $parser->parse($url, $field, $sort);

        return 0;
    }
}
