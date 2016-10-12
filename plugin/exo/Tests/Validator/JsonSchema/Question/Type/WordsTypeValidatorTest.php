<?php

namespace UJM\ExoBundle\Tests\Validator\JsonSchema\Question\Type;

use UJM\ExoBundle\Library\Testing\Json\JsonSchemaTestCase;
use UJM\ExoBundle\Validator\JsonSchema\Misc\KeywordValidator;
use UJM\ExoBundle\Validator\JsonSchema\Question\Type\WordsTypeValidator;

class WordsTypeValidatorTest extends JsonSchemaTestCase
{
    /**
     * @var WordsTypeValidator
     */
    private $validator;

    /**
     * @var KeywordValidator
     */
    private $keywordValidator;

    protected function setUp()
    {
        parent::setUp();

        // Do not validate Keywords
        $this->keywordValidator = $this->mock('UJM\ExoBundle\Validator\JsonSchema\Misc\KeywordValidator');
        $this->keywordValidator->expects($this->any())
            ->method('validateCollection')
            ->willReturn([]);

        $this->validator = $this->injectJsonSchemaMock(
            new WordsTypeValidator($this->keywordValidator)
        );
    }

    /**
     * The validator MUST execute validation for its keywords when `solutionRequired`.
     */
    public function testSolutionKeywordsAreValidatedToo()
    {
        $questionData = $this->loadExampleData('question/words/examples/valid/multiple-answers.json');

        $this->keywordValidator->expects($this->exactly(1))
            ->method('validateCollection');

        $this->validator->validate($questionData, ['solutionsRequired' => true]);
    }
}