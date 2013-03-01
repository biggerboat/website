<?php function crewBlock($name, $description, $skills, $portfolio_url, $twitter_url, $linkedin_url, $contact)
{
    $string = "<li>                                                                                ";
    $string .= "    <div class=\"head\"></div>                                                      ";
    $string .= "    <div class=\"content\">                                                         ";
    $string .= "        <h2>$name</h2>                                               ";
    $string .= "        <p class=\"bio\">$description</p>                                                       ";

    if ($skills) {
        $string .= "        <h3 class=\"skills\">Skills</h3>                                            ";
        $string .= "        <p class=\"skills\">$skills</p>        ";
    }

    $string .= "        <div class=\"howtocontact\">                                                ";
    $string .= "            <div class=\"links\">                                                   ";
    if ($portfolio_url != "") {
        $string .= "                <a href=\"$portfolio_url\" class=\"portfolio\"><div class=\"button\"></div></a>  ";
    }
    if ($linkedin_url != "") {
        $string .= "                <a href=\"$linkedin_url\" class=\"linkedin\"><div class=\"button\"></div></a>   ";
    }
    if ($twitter_url != "") {
        $string .= "                <a href=\"$twitter_url\" class=\"twitter\"><div class=\"button\"></div></a>    ";
    }
    $string .= "            </div>                                                                  ";

    $string .= "            <div class=\"contact\">                                                 ";
    $string .= $contact;
    $string .= "            </div>                                                                  ";
    $string .= "        </div>                                                                      ";

    $string .= "    </div>                                                                          ";
    $string .= "    <div class=\"foot\"></div>                                                      ";
    $string .= "</li>                                                                               ";
    return $string;
}

?>