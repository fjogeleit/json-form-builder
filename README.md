# JSON Form Builder

Create Dynamic Form-Configurations in a JSON Format to render it with your Frontend Environment of Choice

## Basic Example

### Code
```php
use JsonFormBuilder\JsonForm;
use JsonFormBuilder\JsonForm\FormField\Checkbox;
use JsonFormBuilder\JsonForm\FormField\CheckboxGroup;
use JsonFormBuilder\JsonForm\FormField\Input;
use JsonFormBuilder\JsonForm\FormField\Option;
use JsonFormBuilder\JsonForm\FormField\OptionCollection;
use JsonFormBuilder\JsonForm\FormFieldCollection;
use JsonFormBuilder\JsonForm\FormTextElement\Headline1;
use JsonFormBuilder\JsonForm\FormTextElement\Paragraph;
use JsonFormBuilder\JsonForm\FormTextElementCollection;
use Ramsey\Uuid\Uuid;

$formFields = FormFieldCollection::emptyList()
    ->add(new Input(Uuid::uuid4()->toString(), 'Input', 3))
    ->add(new Checkbox(Uuid::uuid4()->toString(), 'Checkbox', 4))
    ->add(new CheckboxGroup(
        Uuid::uuid4()->toString(),
        'CheckboxGroup',
        5,
        OptionCollection::emptyList()
            ->add(new Option('A', 'A'))
            ->add(new Option('B', 'B'))
    ));

$formElements = FormTextElementCollection::emptyList()
    ->add(new Headline1(Uuid::uuid4()->toString(), 'Your First Dynamic Form', 1))
    ->add(new Paragraph(Uuid::uuid4()->toString(), 'Create your custom Form', 2));

$form = new JsonForm(Uuid::uuid4()->toString(), $formFields, $formElements);
```

### JSON
```json
{
   "jsonFormId":"2febf4cd-9c54-4ca4-b619-b51f6321dc8e",
   "formFields":[
      {
         "formFieldId":"afa99e5a-b585-4d3b-8d03-6c196b7c16eb",
         "label":"Input",
         "defaultValue":null,
         "required":false,
         "visible":true,
         "position":3,
         "formFieldType":"input",
         "inputType":"text",
         "class":"JsonFormBuilder\\JsonForm\\FormField\\Input"
      },
      {
         "formFieldId":"5ab7faba-3547-46c5-a237-6164879c339d",
         "label":"Checkbox",
         "position":4,
         "defaultValue":false,
         "required":false,
         "visible":true,
         "formFieldType":"checkbox",
         "class":"JsonFormBuilder\\JsonForm\\FormField\\Checkbox"
      },
      {
         "formFieldId":"1f4ca288-9f04-48b3-ba93-8367a46f84d4",
         "formFieldType":"checkbox_group",
         "label":"CheckboxGroup",
         "position":5,
         "defaultValue":[

         ],
         "required":false,
         "visible":true,
         "options":[
            {
               "label":"B",
               "value":"B"
            },
            {
               "label":"A",
               "value":"A"
            }
         ],
        "class":"JsonFormBuilder\\JsonForm\\FormField\\CheckboxGroup"
      }
   ],
   "formTextElements":[
      {
         "formTextElementId":"9a9c41b1-3ecf-4eef-a383-98567b0c8a28",
         "formTextElementType":"h1",
         "text":"Your·First·Dynamic·Form",
         "position":1,
         "class":"JsonFormBuilder\\JsonForm\\FormTextElement\\Headline1"
      },
      {
         "formTextElementId":"980954c1-acc5-4025-bc2e-97b4962fcc4f",
         "formTextElementType":"p",
         "text":"Create·your·custom·Form",
         "position":2,
         "class":"JsonFormBuilder\\JsonForm\\FormTextElement\\Paragraph"
      }
   ]
}
```
