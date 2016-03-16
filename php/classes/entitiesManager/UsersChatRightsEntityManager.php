<?php
/**
 * Entity manager for the entity UsersChatRights
 *
 * @package    EntityManager
 * @author     Romain Laneuville <romain.laneuville@hotmail.fr>
 */

namespace classes\entitiesManager;

use \abstracts\EntityManager as EntityManager;
use \classes\entities\UsersChatRights as UsersChatRights;
use \classes\DataBase as DB;

/**
 * Performed database action relative to the UsersChatRights entity class
 *
 * @property   UsersChatRights  $entity  The UsersChatRights entity
 *
 * @todo Move changeRoomName(), addRoomName() and removeRoomName() in a chatRoom entityManager class
 */
class UsersChatRightsEntityManager extends EntityManager
{
    /**
     * Constructor that can take a UsersChatRights entity as first parameter and a Collection as second parameter
     *
     * @param      UsersChatRights  $entity      A UsersChatRights entity object DEFAULT null
     * @param      Collection       $collection  A colection oject DEFAULT null
     */
    public function __construct(UsersChatRights $entity = null, Collection $collection = null)
    {
        parent::__construct($entity, $collection);

        if ($entity === null) {
            $this->entity = new UsersChatRights();
        }
    }

    /**
     * Grant all the rights to the user in the current chat room
     */
    public function grantAll()
    {
        $this->entity->kick     = true;
        $this->entity->ban      = true;
        $this->entity->grant    = true;
        $this->entity->password = true;
        $this->entity->rename   = true;
        $this->saveEntity();
    }

    /**
     * Change a room name in the chat rights table
     *
     * @param      string  $oldRoomName  The old room name
     * @param      string  $newRoomName  The new room name
     *
     * @return     int     The number of rows updated
     */
    public function changeRoomName(string $oldRoomName, string $newRoomName): int
    {
        $sqlMarks = 'UPDATE %s SET `roomName` = %s WHERE `roomName` = %s';
        $sql      = static::sqlFormater(
            $sqlMarks,
            $this->entity->getTableName(),
            DB::quote($newRoomName),
            DB::quote($oldRoomName)
        );

        return (int) DB::exec($sql);
    }

    /**
     * Change a room name in the chat rights table
     *
     * @param      string  $roomName  The new room name
     *
     * @return     int     The number of rows inserted
     */
    public function addRoomName(string $roomName): int
    {
        $sqlMarks = 'INSERT INTO %s VALUES(SELECT `id`, %s, 0, 0, 0, 0, 0 FROM Users)';
        $sql      = static::sqlFormater(
            $sqlMarks,
            $this->entity->getTableName(),
            DB::quote($roomName)
        );

        return (int) DB::exec($sql);
    }

    /**
     * Change a room name in the chat rights table
     *
     * @param      string  $roomName  The old room name
     *
     * @return     int     The number of rows deleted
     */
    public function removeRoomName(string $roomName): int
    {
        $sqlMarks = 'DELETE FROM %s WHERE `roomName` = %s';
        $sql      = static::sqlFormater(
            $sqlMarks,
            $this->entity->getTableName(),
            DB::quote($roomName)
        );

        return (int) DB::exec($sql);
    }
}
