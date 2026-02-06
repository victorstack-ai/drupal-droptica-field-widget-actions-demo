# Droptica Field Widget Actions Demo

This demo module adds a custom field widget with an inline **Generate** action that auto-fills text fields.
It is designed as a practical example for an "Automated Content Creation" tutorial with reproducible results.

## What it does

- Adds an **Auto content textarea** widget for `string` and `string_long` fields.
- Exposes a **Generate** action that fills the field with a structured, readable snippet.
- Uses a small generator service so results are consistent and testable.
- Refreshes the widget via AJAX so editors see results immediately.

## Example result

When a field already contains a hint like `Quarterly update`, clicking **Generate** produces output similar to:

```
Quarterly update: A clear summary, a concrete next step, and a friendly call to action.

Key points:
- What changed
- Why it matters
- What to do next
```

Another example with the hint `Roadmap sync`:

```
Roadmap sync: A quick update with the outcome, the evidence, and the next milestone.

Highlights:
- Outcome
- Evidence
- Next milestone
```

## Install

1. Place the module folder in `modules/custom`.
2. Enable **Droptica Field Widget Actions Demo**.
3. Edit a content type, add a text field, and select **Auto content textarea** as the widget.
4. Start typing a hint (for example "Launch recap") and click **Generate**.

## Notes

- This demo does not rely on external APIs.
- The generator is deterministic when provided a single template (used in tests).

## Local QA

Run project QA from agent-hq using the sandbox-bypass job:

```
python3 jobs/run_project_qa.py /Users/victorcamilojimenezvargas/Projects/drupal-droptica-field-widget-actions-demo
```
