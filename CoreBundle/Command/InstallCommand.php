<?php

namespace Gravity\CoreBundle\Command;

use Doctrine\ORM\EntityManager;
use Gravity\CoreBundle\Entity\Block;
use Gravity\CoreBundle\Entity\Field;
use Gravity\CoreBundle\Entity\LayoutPosition;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class InstallCommand
 *
 * @package Gravity\CoreBundle\Command
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class InstallCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('gravity:install')
            ->setDescription('Install CMS')
            ->addOption(
                'force',
                null,
                InputOption::VALUE_NONE,
                'Force install'
            );
    }

    /**
     * @inheritdoc
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $container = $this->getContainer();
        /** @var EntityManager $em */
        $em        = $container->get('doctrine')->getManager();

        $layoutManager = $container->get('gravity_cms.theme.layout_manager');

        $force = $input->getOption('force');
        if ($force) {

            foreach ($layoutManager->getPositions() as $position) {
                $positionEntity = new LayoutPosition();
                $positionEntity->setName($position->getName());
                $positionEntity->setDescription($position->getDescription());
                $positionEntity->setDelta($position->getDelta());
                $em->persist($positionEntity);
            }

            foreach ($layoutManager->getBlocks() as $block) {
                $blockEntity = new Block();
                $blockEntity->setType($block->getType());
                $blockEntity->setName($block->getName());
                $blockEntity->setDescription($block->getDescription());
                $em->persist($blockEntity);
            }

            $em->flush();

        } else {
            $output->writeln('Use --force to update the database');
        }
    }
} 
