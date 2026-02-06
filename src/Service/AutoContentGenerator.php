<?php

declare(strict_types=1);

namespace Drupal\droptica_field_widget_actions_demo\Service;

final class AutoContentGenerator
{
    /**
     * @var string[]
     */
    private array $templates;

    /**
     * @param string[] $templates
     */
    public function __construct(array $templates = [])
    {
        $this->templates = $templates ?: [
            "%s: A clear summary, a concrete next step, and a friendly call to action.\n\nKey points:\n- What changed\n- Why it matters\n- What to do next",
            "%s: A quick update with the outcome, the evidence, and the next milestone.\n\nHighlights:\n- Outcome\n- Evidence\n- Next milestone",
            "%s: A short introduction, a helpful detail, and a closing note that invites feedback.",
        ];
    }

    public function generate(string $hint = ''): string
    {
        $subject = trim($hint) !== '' ? trim($hint) : 'This topic';
        $template = $this->templates[array_rand($this->templates)];

        return sprintf($template, $subject);
    }
}
