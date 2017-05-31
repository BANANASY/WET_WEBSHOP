<?php

class menuItems {

    private $xmlPath = 'config/menu.xml';
//    private $current; ++extraToDo++ implement that current menu gets highlighted

    private function getXML($xmlPath) {
        if (simplexml_load_file($xmlPath)) {
//            echo "XML loaded" --success;
            return $menuXML = simplexml_load_file($xmlPath);
        }
    }

    public function mainMenuGenerator($user_role) { //übergeben zusätzlich active menu

        $menuXML = $this->getXML($this->xmlPath);
        switch ($user_role) {
            case "user":
//                echo "loading user";
                foreach ($menuXML->user->menuitem as $user) {
                    
                    echo "<li><a href='" . $user->path . "'>" . $user->name . "</a></li>";
                }
                break;
            case "admin":
//                echo "loading admin";
                foreach ($menuXML->admin->menuitem as $admin) {
                    echo "<li><a href='" . $admin->path . "'>" . $admin->name . "</a></li>";
                }
                break;
            default:
//                echo "loading visitor";
                foreach ($menuXML->visitor->menuitem as $visitor) {
                    echo "<li><a href='" . $visitor->path . "'>" . $visitor->name . "</a></li>";
                }
        }
    }

    public function secondMenuGenerator($user_role) {

        $menuXML = $this->getXML($this->xmlPath);
        switch ($user_role) {
            case "user":
//                echo "loading user";
                foreach ($menuXML->user->menuitem as $user) {
                    foreach ($user->submenuitem as $sub) {
                        echo "<li><a href='" . $sub->path . "'>" . $sub->name . "</a></li>";
                    }
                }
                break;
            case "admin":
//                echo "loading admin";
                foreach ($menuXML->admin->menuitem as $admin) {
                    foreach ($admin->submenuitem as $sub) {
                        echo "<li><a href='" . $sub->path . "'>" . $sub->name . "</a></li>";
                    }
                }
                break;
            default:
                foreach ($menuXML->visitor->menuitem as $visitor) {
                    foreach ($visitor->submenuitem as $sub) {
                        echo "<li><a href='" . $sub->path . "'>" . $sub->name . "</a></li>";
                    }
                }
        }
    }

}
