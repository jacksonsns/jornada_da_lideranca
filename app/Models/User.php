<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'telefone',
        'padrinho',
        'ano_de_ingresso',
        'password',
        'avatar',
        'role',
        'admin',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Relacionamentos
    public function quadroDosSonhos()
    {
        return $this->hasOne(QuadroDosSonhos::class);
    }

    public function desafios()
    {
        return $this->belongsToMany(Desafio::class)
            ->withPivot('concluido', 'concluido_em')
            ->withTimestamps();
    }

    public function jornadaAspirante()
    {
        return $this->belongsToMany(JornadaAspirante::class, 'jornada_aspirante_user')
            ->withPivot('concluido', 'data_conclusao', 'progresso')
            ->withTimestamps();
    }

    public function escolaLideres()
    {
        return $this->belongsToMany(EscolaLideres::class, 'escola_lideres_user')
            ->withPivot('concluido', 'data_conclusao')
            ->withTimestamps();
    }

    public function capacitacoes()
    {
        return $this->belongsToMany(Capacitacao::class, 'capacitacao_user')
            ->withPivot('concluido', 'data_conclusao')
            ->withTimestamps();
    }

    public function projetosIndividuais()
    {
        return $this->hasMany(ProjetoIndividual::class);
    }

    public function agenda()
    {
        return $this->hasMany(Agenda::class);
    }

    public function areaFinanceira()
    {
        return $this->hasMany(AreaFinanceira::class);
    }

    public function integracaoAcompanhamento()
    {
        return $this->hasMany(IntegracaoAcompanhamento::class, 'user_id');
    }

    public function mentorias()
    {
        return $this->hasMany(IntegracaoAcompanhamento::class, 'mentor_id');
    }

    public function eventos()
    {
        return $this->hasMany(Evento::class);
    }

    public function eventosParticipantes()
    {
        return $this->belongsToMany(Evento::class, 'evento_user')
            ->withPivot('confirmado')
            ->withTimestamps();
    }

    public function conquistas()
    {
        return $this->belongsToMany(Conquista::class, 'conquista_user')
            ->withPivot('conquistado_em')
            ->withTimestamps();
    }

    public function visitas()
    {
        return $this->hasMany(Visita::class);
    }

    public function sonhos()
    {
        return $this->hasMany(Sonho::class);
    }

    public function aulasAssistidas()
    {
        return $this->belongsToMany(Aula::class, 'aulas_assistidas')
            ->withTimestamps();
    }

    public function projetos()
    {
        return $this->hasMany(Projeto::class);
    }

    public function transacoes()
    {
        return $this->hasMany(Transacao::class);
    }

    public function conexoes()
    {
        return $this->belongsToMany(User::class, 'conexoes', 'user_id', 'conexao_id')
            ->withTimestamps();
    }
}
