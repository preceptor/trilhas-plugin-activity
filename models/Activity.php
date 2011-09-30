<?php
/**
 * Trilhas - Learning Management System
 * Copyright (C) 2005-2011  Preceptor Educação a Distância Ltda. <http://www.preceptoead.com.br>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * @category   Activity
 * @package    Activity_Model
 * @copyright  Copyright (C) 2005-2011 Preceptor Educação a Distância Ltda. <http://www.preceptoead.com.br>
 * @license    http://www.gnu.org/licenses/  GNU GPL
 */
class Activity_Model_Activity extends Tri_Model_Abstract
{
    /**
     *
     * @param integer $classroomId
     * @param string  $query
     * @param integer $page
     * 
     * @return Zend_Paginator 
     */
    public function findByClassroom($classroomId, $query = '', $page = 1)
    {
        $table  = new Tri_Db_Table('activity');
        $select = $table->select();

        $select->where('classroom_id = ?', $classroomId)
               ->where('status = ?', 'active')
               ->where('begin <= ?', date('Y-m-d'))
               ->where('end IS NULL OR end > ?', date('Y-m-d'));

        if ($query) {
            $select->where('UPPER(title) LIKE UPPER(?)', "%$query%");
        }

        $paginator = new Tri_Paginator($select, $page);
        return $paginator->getResult();
    }
}