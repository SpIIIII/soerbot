<?php

namespace SoerBot\Commands\Devs;

class TopicCollection
{
    /**
     * @var array
     */
    protected $topics = [];

    /**
     * TopicCollection constructor.
     *
     * @param string $path
     * @throws \Exception
     */
    public function __construct(string $path = __DIR__ . '/store/')
    {
        $this->topics = $this->setupTopics($path);
    }

    /**
     * @param string $key
     * @return bool
     */
    public function has(string $key): bool
    {
        return isset($this->topics[$key]);
    }

    /**
     * @param string $key
     * @return TopicModel
     */
    public function getOne(string $key): ?TopicModel
    {
        return $this->topics[$key] ?? null;
    }

    /**
     * @return string
     */
    public function listNames(): string
    {
        return $this->stringifyTopics();
    }

    /**
     * @param string $path
     * @throws \Exception
     * @return array
     */
    protected function setupTopics(string $path): array
    {
        if (!is_dir($path)) {
            throw new \Exception('DevsCommand error: ' . $path . ' is not a valid directory.');
        }

        $topics = [];

        foreach (new \DirectoryIterator($path) as $file) {
            if ($file->isFile()) {
                try {
                    $topic = TopicModel::create($file->getRealPath());
                } catch (\InvalidArgumentException $e) {
                    continue;
                }
                $topics += $topic;
            }
        }

        if (empty($topics)) {
            throw new \Exception('DevsCommand error: directory ' . $path . ' does not contain topic files.');
        }

        return $topics;
    }

    /**
     * @return string
     */
    protected function stringifyTopics(): string
    {
        ksort($this->topics);

        if (array_key_exists('list', $this->topics)) {
            $output = '';
            foreach (array_keys($this->topics) as $key) {
                if ($key === 'list') {
                    continue;
                }
                $output .= $key . ', ';
            }
            $output .= 'list - to list all command descriptions';

            return $output;
        }

        return implode(', ', array_keys($this->topics));
    }

    /**
     * @return array
     */
    protected function getAll(): array
    {
        return $this->topics;
    }
}
