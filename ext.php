<?php
/**
 *
 * Topics Hierarchy. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2016 - 2017, 3Di, http://3di.space/32/
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace threedi\topicshierarchy;

/**
 * Topics Hierarchy Extension base
 */
class ext extends \phpbb\extension\base
{
	/**
	 * Check whether or not the extension can be enabled.
	 * If not tell the user what's going on and why.
	 *
	 * @return bool
	 */
	public function is_enableable()
	{
		$config = $this->container->get('config');

		if (!phpbb_version_compare($config['version'], '3.2.0', '>='))
		{
			$this->container->get('language')->add_lang('common', 'threedi/topicshierarchy');

			trigger_error($this->container->get('language')->lang('EXTENSION_REQUIREMENTS_NOTICE') . adm_back_link(append_sid('index.' . $this->container->getParameter('core.php_ext'), 'i=acp_extensions&amp;mode=main')), E_USER_WARNING);
		}
		else
		{
			return true;
		}
	}
}
