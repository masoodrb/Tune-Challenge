<?php

namespace Tests\Unit;

use Mockery;
use Tests\TestCase;

use App\GraphQL\Types\UserSort;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use App\GraphQL\Types\SortDirection;
use App\Exceptions\JsonReadException;
use App\GraphQL\Types\EventStatsFilter;
use App\Repositories\UserJsonRepository;
use App\Contracts\FileContentReaderInterface;
use App\GraphQL\Types\DateRange;

class UserJsonRepositoryTest extends TestCase
{
  private $fileContentReader;
  private $userJsonRepository;

  public function setUp(): void
  {
    parent::setUp();

    $this->fileContentReader = Mockery::mock(FileContentReaderInterface::class);
    $this->userJsonRepository = new UserJsonRepository($this->fileContentReader);
  }

  public function tearDown(): void
  {
    Mockery::close();

    parent::tearDown();
  }

  public function test_construct()
  {
    $this->assertInstanceOf(UserJsonRepository::class, $this->userJsonRepository);
  }

  public function test_get_all_users_success()
  {
    $this->fileContentReader->shouldReceive('getFileContent')
      ->twice()
      ->andReturn(json_encode([]));

    $sort = new UserSort();
    $filter = new EventStatsFilter();

    $result = $this->userJsonRepository->getAllUsers($sort, $filter);

    $this->assertInstanceOf(Collection::class, $result);
  }

  public function test_get_all_users_failure()
  {
    $this->fileContentReader->shouldReceive('getFileContent')
      ->twice()
      ->andReturn(false);

    $sort = new UserSort();
    $filter = new EventStatsFilter();

    $this->expectException(JsonReadException::class);

    $this->userJsonRepository->getAllUsers($sort, $filter);
  }

  public function test_get_all_users_sorting()
  {
    $this->fileContentReader->shouldReceive('getFileContent')
      ->once()
      ->andReturn(json_encode([
        ['id' => 3, 'name' => 'User C'],
        ['id' => 1, 'name' => 'User A'],
        ['id' => 2, 'name' => 'User B'],
      ]));

    $this->fileContentReader->shouldReceive('getFileContent')
      ->once()
      ->andReturn(json_encode([
        ['user_id' => 1, 'type' => 'impression', 'time' => '2018-01-01 00:00:00'],
        ['user_id' => 1, 'type' => 'conversion', 'time' => '2018-01-01 00:00:00'],
        ['user_id' => 2, 'type' => 'impression', 'time' => '2018-01-01 00:00:00'],
        ['user_id' => 2, 'type' => 'conversion', 'time' => '2018-01-01 00:00:00'],
        ['user_id' => 3, 'type' => 'impression', 'time' => '2018-01-01 00:00:00'],
        ['user_id' => 3, 'type' => 'conversion', 'time' => '2018-01-01 00:00:00'],
      ]));

    $sort = new UserSort();
    $sort->setField('id');
    $sort->setDirection(SortDirection::ASC);

    $filter = new EventStatsFilter();

    $result = $this->userJsonRepository->getAllUsers($sort, $filter);
    $this->assertInstanceOf(Collection::class, $result);
    
    $result = $result->values()->toArray();
    $this->assertEquals(1, $result[0]['id']);
    $this->assertEquals(2, $result[1]['id']);
    $this->assertEquals(3, $result[2]['id']);
  }

  public function test_filter_by_date_range()
  {
    $this->fileContentReader->shouldReceive('getFileContent')
    ->once()
    ->andReturn(json_encode([
      ['id' => 3, 'name' => 'User C'],
      ['id' => 1, 'name' => 'User A'],
      ['id' => 2, 'name' => 'User B'],
    ]));

    $this->fileContentReader->shouldReceive('getFileContent')
      ->once()
      ->andReturn(json_encode([
        ['user_id' => 1, 'type' => 'impression', 'time' => '2018-01-01 00:00:00'],
        ['user_id' => 1, 'type' => 'conversion', 'time' => '2018-01-02 00:00:00'],
        ['user_id' => 2, 'type' => 'impression', 'time' => '2018-01-03 00:00:00'],
        ['user_id' => 2, 'type' => 'conversion', 'time' => '2018-01-04 00:00:00'],
        ['user_id' => 3, 'type' => 'impression', 'time' => '2018-01-05 00:00:00'],
        ['user_id' => 3, 'type' => 'conversion', 'time' => '2018-01-06 00:00:00'],
      ]));

    $sort = new UserSort();
    $filter = new EventStatsFilter();
    $filter->dateRange = new DateRange('2018-01-01 00:00:00', '2018-01-03 00:00:00');

    $result = $this->userJsonRepository->getAllUsers($sort, $filter);
    $this->assertInstanceOf(Collection::class, $result);
    $this->assertEquals(3, $result->count());
  }

  public function test_filter_by_type()
  {
    $this->fileContentReader->shouldReceive('getFileContent')
    ->once()
    ->andReturn(json_encode([
      ['id' => 3, 'name' => 'User C'],
      ['id' => 1, 'name' => 'User A'],
      ['id' => 2, 'name' => 'User B'],
    ]));

    $this->fileContentReader->shouldReceive('getFileContent')
      ->once()
      ->andReturn(json_encode([
        ['user_id' => 1, 'type' => 'impression', 'time' => '2018-01-01 00:00:00'],
        ['user_id' => 1, 'type' => 'conversion', 'time' => '2018-01-02 00:00:00'],
        ['user_id' => 2, 'type' => 'impression', 'time' => '2018-01-03 00:00:00'],
        ['user_id' => 2, 'type' => 'conversion', 'time' => '2018-01-04 00:00:00'],
        ['user_id' => 3, 'type' => 'impression', 'time' => '2018-01-05 00:00:00'],
        ['user_id' => 3, 'type' => 'conversion', 'time' => '2018-01-06 00:00:00'],
      ]));

    $sort = new UserSort();
    $filter = new EventStatsFilter();
    $filter->type = 'impression';

    $result = $this->userJsonRepository->getAllUsers($sort, $filter);
    $this->assertInstanceOf(Collection::class, $result);
    $this->assertEquals(3, $result->count());
  }
}
