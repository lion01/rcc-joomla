<?php
/**
* @package		EasyDiscuss
* @copyright	Copyright (C) 2010 Stack Ideas Private Limited. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* EasyDiscuss is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/
defined('_JEXEC') or die('Restricted access');

jimport( 'joomla.application.component.view');

class EasyDiscussViewIndex extends EasyDiscussView
{
	function display( $tmpl = null )
	{
		$document		= JFactory::getDocument();
		$document->link	= JRoute::_('index.php?option=com_easydiscuss&view=index');

		$document->setTitle( $this->escape( $document->getTitle() ) );

		$sort			= JRequest::getString('sort', 'latest');
		$filter			= JRequest::getString('filter', 'allposts');
		$category		= JRequest::getInt( 'category_id' , 0 );

		$postModel		= $this->getModel('Posts');
		$posts			= $postModel->getData( true , $sort , null , $filter , $category );
		$pagination		= $postModel->getPagination( '0' , $sort , $filter , $category );

		$posts			= DiscussHelper::formatPost($posts);

		require_once DISCUSS_HELPERS . '/parser.php';

		foreach( $posts as $row )
		{
			// Assign to feed item
			$title	= $this->escape( $row->title );
			$title	= html_entity_decode( $title );
			$category = DiscussHelper::getTable( 'Category' );
			$category->load( $row->category_id );

			// load individual item creator class
			$item				= new JFeedItem();

			//Problems with other language
			//$item->title		= htmlentities( $title );
			$item->title		= $row->title;

			$item->link			= JRoute::_('index.php?option=com_easydiscuss&view=post&id=' . $row->id );
			$row->content		= DiscussHelper::parseContent( $row->content );

			// Problems with other language
			//$item->description	= htmlentities( $row->content );
			$item->description	= $row->content;

			$item->date			= DiscussHelper::getDate( $row->created )->toMySQL();
			$item->author		= $row->user->getName();
			$item->authorEmail	= $row->user->user->email;
			$item->category		= $category->getTitle();

			$document->addItem( $item );
		}
	}
}
