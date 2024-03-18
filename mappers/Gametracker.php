<?php
/**
 * @copyright Ilch 2
 * @package ilch
 */

namespace Modules\Gametracker\Mappers;

use Modules\Gametracker\Models\Gametracker as GametrackerModel;

class Gametracker extends \Ilch\Mapper
{
    /**
     * Gets the Gametracker entries.
     *
     * @param array $where
     * @return GametrackerModel[]|array
     */
    public function getEntries($where = [])
    {
        return $this->getGametrackersBy($where, ['id' => 'DESC']);
    }

    /**
     * Gets gametrackers.
     *
     * @param array $where
     * @param array $orderBy
     * @return GametrackerModel[]|array
     */
    public function getGametrackersBy($where = [], $orderBy = ['id' => 'ASC'])
    {
        $gametrackerArray = $this->db()->select('*')
            ->from('gametrackers')
            ->where($where)
            ->order($orderBy)
            ->execute()
            ->fetchRows();

        if (empty($gametrackerArray)) {
            return [];
        }

        $gametrackers = [];
        foreach ($gametrackerArray as $gametrackerRow) {
            $gametrackerModel = new GametrackerModel();
            $gametrackerModel->setId($gametrackerRow['id'])
                ->setName($gametrackerRow['name'])
                ->setLink($gametrackerRow['link'])
                ->setBanner($gametrackerRow['banner'])
                ->setTarget($gametrackerRow['target'])
                ->setFree($gametrackerRow['setfree']);
            $gametrackers[] = $gametrackerModel;
        }

        return $gametrackers;
    }

    /**
     * Gets gametracker.
     *
     * @param integer $id
     * @return GametrackerModel|null
     */
    public function getGametrackerById($id)
    {
        $gametrackerRow = $this->db()->select('*')
            ->from('gametrackers')
            ->where(['id' => $id])
            ->execute()
            ->fetchAssoc();

        if (empty($gametrackerRow)) {
            return null;
        }

        $gametrackerModel = new GametrackerModel();
        $gametrackerModel->setId($gametrackerRow['id'])
            ->setName($gametrackerRow['name'])
            ->setLink($gametrackerRow['link'])
            ->setBanner($gametrackerRow['banner'])
            ->setTarget($gametrackerRow['target']);

        return $gametrackerModel;
    }

    /**
     * Inserts or updates gametracker model.
     *
     * @param GametrackerModel $gametracker
     */
    public function save(GametrackerModel $gametracker)
    {
        $fields = [
            'name' => $gametracker->getName(),
            'link' => $gametracker->getLink(),
            'banner' => $gametracker->getBanner(),
            'target' => $gametracker->getTarget(),
            'setfree' => $gametracker->getFree()
        ];

        if ($gametracker->getId()) {
            $this->db()->update('gametrackers')
                ->values($fields)
                ->where(['id' => $gametracker->getId()])
                ->execute();
        } else {
            $this->db()->insert('gametrackers')
                ->values($fields)
                ->execute();
        }
    }

    /**
     * Updates the position of a gametracker in the database.
     *
     * @param int $id
     * @param int $position
     */
    public function updatePositionById($id, $position)
    {
        $this->db()->update('gametrackers')
            ->values(['pos' => $position])
            ->where(['id' => $id])
            ->execute();
    }

    /**
     * Deletes gametracker with given id.
     *
     * @param integer $id
     */
    public function delete($id)
    {
        $this->db()->delete('gametrackers')
            ->where(['id' => $id])
            ->execute();
    }
}
