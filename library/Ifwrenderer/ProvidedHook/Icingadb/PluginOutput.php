<?php

namespace Icinga\Module\Ifwrenderer\ProvidedHook\Icingadb;


class PluginOutput extends \Icinga\Module\Icingadb\Hook\PluginOutputHook
{

    protected $TEXT_PATTERNS = [
        '~(\[|\()INFO(\]|\))~',
    ];

    /** @var string[] Replacements for {@see PluginOutput::TEXT_PATTERNS} */
    protected $TEXT_REPLACEMENTS = [
        '<span class="state-ball ball-size-m state-info"></span>',
    ];
    /**
     * Return whether the given command is supported or not
     *
     * @param string $commandName
     *
     * @return bool
     */
    public function isSupportedCommand(string $commandName): bool{

        if(strpos($commandName, "Invoke-Icinga") !== false){
            return true;
        }
        return false;
    }

    /**
     * Process the given plugin output based on the specified check command
     *
     * Try to process the output as efficient and fast as possible.
     * Especially list view performance may suffer otherwise.
     *
     * @param string $output A host's or service's output
     * @param string $commandName The name of the checkcommand that produced the output
     * @param bool $enrichOutput Whether macros or other markup should be processed
     *
     * @return string
     */
    public function render(string $output, string $commandName, bool $enrichOutput): string{

        $output = preg_replace(
            $this->TEXT_PATTERNS,
            $this->TEXT_REPLACEMENTS,
            htmlspecialchars($output, ENT_COMPAT | ENT_SUBSTITUTE | ENT_HTML5, null, false)
        );
        return "<div class='preformatted icinga-module module-ifwrenderer'>".$output."</div>";

    }


}
