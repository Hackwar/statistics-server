<?php
/**
 * Joomla! Statistics Server
 *
 * @copyright  Copyright (C) 2013 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license    http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License Version 2 or Later
 */

namespace Joomla\StatsServer;

use Joomla\Application\AbstractCliApplication;
use Joomla\Application\Cli\{
	CliInput, CliOutput
};
use Joomla\Input\Cli;
use Joomla\Registry\Registry;

/**
 * CLI application for the stats server
 *
 * @since  1.0
 */
class CliApplication extends AbstractCliApplication
{
	/**
	 * The application's console object
	 *
	 * @var    Console
	 * @since  1.0
	 */
	private $console;

	/**
	 * CliApplication constructor.
	 *
	 * @param   Input\Cli  $input     The application's input object.
	 * @param   Registry   $config    The application's configuration.
	 * @param   CliOutput  $output    The application's output object.
	 * @param   CliInput   $cliInput  The application's CLI input handler.
	 * @param   Console    $console   The application's console object.
	 */
	public function __construct(Cli $input, Registry $config, CliOutput $output, CliInput $cliInput, Console $console)
	{
		parent::__construct($input, $config, $output, $cliInput);

		$this->console = $console;
	}

	/**
	 * Method to run the application routines.
	 *
	 * @return  void
	 *
	 * @since   1.0
	 * @throws  \InvalidArgumentException
	 */
	protected function doExecute()
	{
		$args = $this->input->args;

		$command  = !empty($args[0]) ? $args[0] : 'help';
		$commands = $this->getConsole()->getCommands();

		if (!array_key_exists($command, $commands))
		{
			throw new \InvalidArgumentException(sprintf('The "%s" command is not valid.', $command));
		}

		// Execute the command
		$commands[$command]->execute();
	}

	/**
	 * Get the application's console object
	 *
	 * @return  Console
	 *
	 * @since   1.0
	 */
	public function getConsole() : Console
	{
		return $this->console;
	}

	/**
	 * Output a nicely formatted title for the application.
	 *
	 * @param   string  $title     The title to display.
	 * @param   string  $subTitle  A subtitle.
	 * @param   int     $width     Total width in chars.
	 *
	 * @return  $this
	 *
	 * @since   1.0
	 */
	public function outputTitle(string $title, string $subTitle = '', int $width = 60) : CliApplication
	{
		$this->out(str_repeat('-', $width));
		$this->out(str_repeat(' ', $width / 2 - (strlen($title) / 2)) . '<title>' . $title . '</title>');

		if ($subTitle)
		{
			$this->out(str_repeat(' ', $width / 2 - (strlen($subTitle) / 2)) . '<b>' . $subTitle . '</b>');
		}

		$this->out(str_repeat('-', $width));

		return $this;
	}
}
