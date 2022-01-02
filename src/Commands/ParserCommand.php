<?php

namespace Console\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;
use Console\Services\ParseService;

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
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $url = $input->getOption('url');
        $output->writeln(sprintf('Receive parse url %s', $url));

        $parser = new ParseService();
        $parser->parse($url);

        return 0;
    }
}
