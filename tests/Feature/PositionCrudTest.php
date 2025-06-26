<?php

use App\Models\Position;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;
use function Pest\Laravel\post;
use function Pest\Laravel\put;
use function Pest\Laravel\delete;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->admin = User::factory()->create(['role' => 'admin']);
});

describe('Position CRUD', function() {

    test('admin can view positions page', function () {
        actingAs($this->admin)
            ->get(route('positions.index'))
            ->assertOk()
            ->assertSee('Manajemen Jabatan');
    });

    test('admin can create a new position', function () {
        $positionName = 'Product Manager';

        actingAs($this->admin)
            ->post(route('positions.store'), [
                'nama_jabatan' => $positionName,
            ])
            ->assertRedirect(route('positions.index'))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('positions', [
            'nama_jabatan' => $positionName
        ]);
    });

    test('position creation requires a name', function () {
        actingAs($this->admin)
            ->post(route('positions.store'), ['nama_jabatan' => ''])
            ->assertSessionHasErrors('nama_jabatan');
    });

    test('admin can update a position', function () {
        $position = Position::factory()->create(['nama_jabatan' => 'Sales Executive']);
        $newPositionName = 'Senior Sales Executive';

        actingAs($this->admin)
            ->put(route('positions.update', $position), [
                'nama_jabatan' => $newPositionName,
            ])
            ->assertRedirect(route('positions.index'))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('positions', ['nama_jabatan' => $newPositionName]);
        $this->assertDatabaseMissing('positions', ['nama_jabatan' => 'Sales Executive']);
    });

    test('admin can delete a position', function () {
        $position = Position::factory()->create();

        actingAs($this->admin)
            ->delete(route('positions.destroy', $position))
            ->assertRedirect(route('positions.index'))
            ->assertSessionHas('success');
        
        $this->assertDatabaseMissing('positions', [
            'id' => $position->id
        ]);
    });
});
