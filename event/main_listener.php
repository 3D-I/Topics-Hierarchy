<?php
/**
 *
 * Topics Hierarchy. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2016 - 2017, 3Di, http://3di.space/32/
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace threedi\topicshierarchy\event;

/**
 * @ignore
 */
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Topics Hierarchy Event listener.
 */
class main_listener implements EventSubscriberInterface
{
	/** @var \phpbb\language\language $language Language object */
	protected $language;

	/**
	 * Constructor
	 *
	 * @param \phpbb\language\language $language
	 */
	public function __construct(
		\phpbb\language\language $language)
	{
		$this->language = $language;
	}

	static public function getSubscribedEvents()
	{
		return array(
			'core.viewforum_get_announcement_topic_ids_data'	=> 'viewforum_get_announcement_topic_ids_data',
			'core.viewforum_modify_topicrow'					=> 'viewforum_modify_topicrow',
			'core.viewforum_topic_row_after'					=> 'viewforum_topic_row_after',
		);
	}

	/**
	 * Sort topics by type and last post time in all cases
	 * Modifies the SQL query before the announcement topic ids data is retrieved
	 *
	 * @param \phpbb\event\data	$event	Event object
	 */
	public function viewforum_get_announcement_topic_ids_data($event)
	{
		$sql_ary = $event['sql_ary'];

		$sql_ary['ORDER_BY'] = 't.topic_type DESC, t.topic_last_post_time DESC';

		$event['sql_ary'] = $sql_ary;
	}

	/**
	 * Modifies the topic data before it is assigned to the template
	 *
	 * @param \phpbb\event\data	$event	Event object
	 */
	public function viewforum_modify_topicrow($event)
	{
		$this->language->add_lang('common', 'threedi/topicshierarchy');

		$row = $event['row'];
		$topic_row = $event['topic_row'];
		$s_type_switch = (int) $event['s_type_switch'];
		$s_type_switch_test = (int) $row['topic_type'];

		$topic_row['S_TOPIC_TYPE_SWITCH'] = ($s_type_switch == $s_type_switch_test) ? -1 : 0;

		$event['topic_row'] = $topic_row;
	}

	/**
	 * Modifies the topic data after the topic data has been assigned to the template
	 *
	 * @param \phpbb\event\data	$event	Event object
	 */
	public function viewforum_topic_row_after($event)
	{
		$row = $event['row'];

		$s_type_switch = $row['topic_type'];

		$event['s_type_switch'] = $s_type_switch;
	}
}
