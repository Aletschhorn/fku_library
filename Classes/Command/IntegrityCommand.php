<?php
namespace FKU\FkuLibrary\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Mime\Address;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Mail\MailMessage;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use FKU\FkuLibrary\Domain\Repository\MediaRepository;

class IntegrityCommand extends Command {

    /**
     * Configure the command
     */
    protected function configure() {
        $this->setDescription('Checks the integrity of the media');
        $this->setHelp('Checks several switchable parameters of the media entries in the database.');
		$this->addArgument('address',InputArgument::REQUIRED,'E-mail address where the report is sent to');
		$this->addArgument('checkRegisterId', InputArgument::REQUIRED, 'Boolean (0/1): 1 = media register ID is checked');
		$this->addArgument('checkTitle', InputArgument::REQUIRED, 'Boolean (0/1): 1 = media title is checked');
		$this->addArgument('checkTitlePercent', InputArgument::OPTIONAL, 'Threshold in percentage (1-100) of title similarity. Optional. Default = 80');
    }

    /**
     * Executes the command
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output) {

        $io = new SymfonyStyle($input, $output);
		$address = $input->getArgument('address');
		if (strlen($address) == 0) {
			$io->writeln('Nothing checking because of missing e-mail address');
			return 0;
		}
		
		$checkRegisterId = $input->getArgument('checkRegisterId');
		$checkTitle = $input->getArgument('checkTitle');
		$checkTitlePercent = intval($input->getArgument('checkTitlePercent'));
		$objectManager = GeneralUtility::makeInstance(ObjectManager::class);
		$this->mediaRepository = $objectManager->get(MediaRepository::class);
		
		if ($checkRegisterId || $checkTitle) {
			if ($checkTitle) {
				if ($checkTitlePercent > 100 || $checkTitlePercent < 1) {
					$checkTitlePercent = 80;
				}
			}
			$issues = [];
			$media1 = $this->mediaRepository->findAllSorted('uid',true); // all media in reverse ID order
			$media2 = $this->mediaRepository->findAllSorted('uid',false); // all media in normal ID order
			
			$counter = 0;
			foreach ($media1 as $m1) {
				foreach ($media2 as $m2) {
					// compare media of higest ID with all all media starting from lowest ID until they have the same ID
					if ($m1 == $m2) {
						break;
					}
					$counter++;
					// checks if register IDs are different
					if ($checkRegisterId) {
						if ($m1->getRegisterId() == $m2->getRegisterId()) {
							$issues[] = 'Die Bücher "'.$m2->getTitle().'" und "'.$m1->getTitle().'" haben die gleiche Buch-Nummer: '.$m1->getRegisterId().'.';
						}
					}
					// checks if titles are similar
					if ($checkTitle) {
						similar_text(strtolower($m2->getTitle()), strtolower($m1->getTitle()), $percent);
						if ($percent >= $checkTitlePercent) {
							$issues[] = 'Die Bücher "'.$m2->getTitle().'", Buch-Nummer '.$m2->getRegisterId().', und "'.$m1->getTitle().'", Buch-Nummer '.$m1->getRegisterId().', haben (fast) den gleichen Titel.';
						}
					}
				}
			}
			
			if (count($issues) > 0) {
				// create notification e-mail
				$textPlain = 'Die Bücher der Bibliothek wurden geprüft und folgende Probleme gefunden:'.chr(13).chr(13);
				$textHtml = '<html>'.chr(13).'<head>'.chr(13).'<style>'.chr(13).'body {font-family: Calibri,Arial,Helvetica,sans-serif; font-size: 14px;}'.chr(13).'</style>'.chr(13).'</head>'.chr(13).'<body><b>Die Bücher der Bibliothek wurden geprüft und folgende Probleme gefunden:</b><br /><br /><ul>';
				foreach ($issues as $issue) {
					$textPlain .= '- '.$issue.chr(13);
					$textHtml .= '<li>'.$issue.'</li>';
				}
				$textPlain .= chr(13).chr(13).'----------'.chr(13).'Dies ist eine automatische Nachricht. Bei Fragen zu diesem dazu, wende dich bitte an Daniel Widmer (daniel.widmer@fku.ch).';
				$textHtml .= '</ul><br /><br /><hr><br />Dies ist eine automatische Nachricht. Bei Fragen zu diesem dazu, wende dich bitte an Daniel Widmer (daniel.widmer@fku.ch).</body></html>';

				// send notification e-mail
				$message = GeneralUtility::makeInstance(MailMessage::class);
				$message
					->from(new Address('notification@fku.ch', 'FKU-Bibliothek'))
					->to(new Address($address))
					->subject('Test-Resultate FKU-Bibliothek-Check')
					->text($textPlain)
					->html($textHtml)
					->send();

				$io->writeln('Issues found and e-mail sent.');
				return 0;
			} else {
				$io->writeln('No issues found, no e-mail sent.');
				return 0;
			}
		} else {
			return 0;
		}
	}

}
?>