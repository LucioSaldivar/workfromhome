<?php
declare(strict_types=1);

namespace SocialApp\views\ListView;

use SocialApp\Model\SocialMediaModel;
use SocialApp\views\MainView;

class SocialMediaAll extends MainView
{
    /**
     * @param SocialMediaModel[] $list
     * @return string
     */
    public function getHtml(array $list): string
    {
        $listItems = "";
        foreach ($list as $item) {
            $listItems .= "<tr>
                                <td>" . $item->getTitle() . "</td>
                                <td>" . $item->getUrl() . "</td>
                            </tr>";
        }

        return
            $this->mainHtml("<table>
                                            <tr>
                                            <th>Social Title</th>
                                            <th>Social Url</th>
                                            </tr>
                                            " . $listItems . "
                                        </table>"
            );
    }
}