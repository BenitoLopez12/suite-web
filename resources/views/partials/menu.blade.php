<link rel="stylesheet" type="text/css" href="{{ asset('css/dark_mode.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('css/menu.css') }}">



<div id="sidebar" class="c-sidebar c-sidebar-fixed c-sidebar-lg-show c-sidebar-light" style=" border: none;">

    <div class="bg-transparent c-sidebar-brand d-md-down-none caja_caja_img_logo">

       <!-- <div class="text-center dark_mode1" style="padding-top: 20px;">-->
               {{--<a href="{{url('/')}}" class="pl-0"><img src="{{ asset('img/Silent4Business-Logo-Color.png') }}" style="width: 40%;" class="img_logo"></a> --}}
            <div class="caja_img_logo">
               <?php
                use Illuminate\Support\Facades\DB;
                $users = DB::table('organizacions')
                ->select('logotipo')
                ->first();

                if (isset($users)) { ?>
                <img src="{{ asset('images/' . $users->logotipo )}}" class="img_logo w-100">
                <?php } elseif (!isset($users)) { ?>
                <img  src="{{ asset('img/silent4business.png') }}" class="img_logo w-100">
                <?php } else { ?>
                <img src="{{ asset('img/silent4business.png') }}" class="img_logo w-100">
                <?php }
                ?>


            </div>

    </div>



    <ul class="c-sidebar-nav dark_mode1">

    <li class="c-sidebar-nav-title"><font class="letra_blanca">Menu</font></li>
        @can('organizacion_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/matriz-riesgos*") ? "c-show" : "" }} {{ request()->is("admin/gap-unos*") ? "c-show" : "" }} {{ request()->is("admin/gap-dos*") ? "c-show" : "" }} {{ request()->is("admin/gap-tres*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                  <i class="fas fa-building iconos_menu letra_blanca"></i>
                    <font class="letra_blanca"> Mi Organización </font>
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    <li class="c-sidebar-nav-item">
                        <a href="{{ route("admin.organizacions.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/organizacions") || request()->is("admin/organizacions/*") ? "active" : "" }}">
                            <i class="fas fa-bullseye iconos_menu letra_blanca">

                            </i>
                            <font class="letra_blanca" style="margin-left:5px;"> Organización</font>
                        </a>
                    </li>
                    @can('sede_access')
                    <li class="c-sidebar-nav-item">
                        <a href="{{ route("admin.sedes.obtenerListaSedes") }}" class="c-sidebar-nav-link {{ request()->is("admin/sedes") || request()->is("admin/sedes/*") ? "active" : "" }}">
                            <i class="fas fa-map-marked-alt iconos_menu letra_blanca">

                            </i>
                            <font class="letra_blanca"> Sedes</font>
                        </a>
                    </li>
                @endcan
                @can('area_access')
                <li class="c-sidebar-nav-item">
                    <a href="{{ route("admin.areas.renderJerarquia") }}" class="c-sidebar-nav-link {{ request()->is("admin/areas") || request()->is("admin/areas/*") ? "active" : "" }}">
                        {{--<i class="fas fa-puzzle-piece iconos_menu letra_blanca">

                        </i>--}}
                        <i class="fab fa-adn iconos_menu letra_blanca">

                        </i>
                        <font class="letra_blanca"> {{ trans('cruds.area.title') }} </font>
                    </a>
                </li>
                 @endcan
                 <li class="c-sidebar-nav-item">
                    <a href="{{ route("admin.organigrama.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/organigrama") || request()->is("admin/organigrama/*") ? "c-active" : "" }}">
                        <i class="fas fa-users iconos_menu letra_blanca">
                        </i>
                        <font class="letra_blanca"> Organigrama </font>
                    </a>
                </li>
                <li class="c-sidebar-nav-item">
                    <a href="{{ route("admin.procesos.mapa") }}" class="c-sidebar-nav-link {{ request()->is("admin/procesos/mapa_procesos") || request()->is("admin/procesos/mapa-procesos") ? "c-active" : "" }}">
                        <i class="fas fa-th iconos_menu letra_blanca"></i>
                        <font class="letra_blanca"> Mapa de procesos </font>
                    </a>
                </li>
                </ul>
            </li>
        @endcan
        @can('dashboard_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.home") }}" class="c-sidebar-nav-link {{ request()->is("admin/dashboards") || request()->is("admin/dashboards/*") ? "active" : "" }}">
                    <i class="fa-fw far fa-chart-bar iconos_menu letra_blanca">

                    </i>
                    <font class="letra_blanca"> {{ trans('cruds.dashboard.title') }} </font>
                </a>
            </li>
        @endcan
        <li class="c-sidebar-nav-item">
            <a href="{{ route("admin.inicio-Usuario.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/inicioUsuario") || request()->is("admin/inicioUsuario/*") ? "active" : "" }}">
                <i class="fas fa-user iconos_menu letra_blanca"></i>

                </i>
                <font class="letra_blanca"> Inicio de usuario</font>
            </a>
        </li>
        <li class="c-sidebar-nav-item">
            <a href="{{ route("admin.planTrabajoBase.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/planTrabajoBase") || request()->is("admin/planTrabajoBase/*") ? "active" : "" }}">
                <i class="fas fa-clipboard-list iconos_menu letra_blanca"></i>

                </i>
                <font class="letra_blanca"> Plan de trabajo base </font>
            </a>
        </li>
        <li class="c-sidebar-nav-item">
            <a href="{{ url('/admin/analisis-brechas') }}" class="c-sidebar-nav-link">
                <i class="iconos_menu letra_blanca fas fa-fw fa-file-signature">

                </i>
              <font class="letra_blanca"> Análisis de brechas</font>
            </a>
        </li>
        @can('implementacion_access')
            {{-- <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.implementacions.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/implementacions") || request()->is("admin/implementacions/*") ? "active" : "" }}">

                    <i class="fas fa-paper-plane iconos_menu letra_blanca"></i>
                    <font class="letra_blanca"> {{ trans('cruds.implementacion.title') }} </font>
                </a>
            </li> --}}
        @endcan
     @can('documentacion_access')
            <li
                class="c-sidebar-nav-dropdown {{ request()->is('admin/carpeta*') ? 'c-show' : '' }} {{ request()->is('admin/crear-documentos*') ? 'c-show' : '' }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fas fa-folder iconos_menu letra_blanca"></i>
                    <font class="letra_blanca"> Documentos </font>
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('matriz_riesgo_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route('admin.documentos.index') }}"
                                class="c-sidebar-nav-link {{ request()->is('admin/crear-documentos') || request()->is('admin/crear-documentos*') ? 'active' : '' }}">
                                <i class="fas fa-folder-plus iconos_menu letra_blanca"></i>
                                <font class="letra_blanca"> Crear Documentos </font>
                            </a>
                        </li>
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route('admin.carpeta.index') }}"
                                class="c-sidebar-nav-link {{ request()->is('admin/carpeta') || request()->is('admin/carpeta/*') ? 'active' : '' }}">
                                <i class="fas fa-folder-open iconos_menu letra_blanca"></i>
                                <font class="letra_blanca"> Gestor Documental </font>
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
            
        @endcan
        @can('analisis_riesgo_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/matriz-riesgos*") ? "c-show" : "" }} {{ request()->is("admin/gap-unos*") ? "c-show" : "" }} {{ request()->is("admin/gap-dos*") ? "c-show" : "" }} {{ request()->is("admin/gap-tres*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                  <i class="fas fa-exclamation-triangle iconos_menu letra_blanca">

                  </i>

                    <font class="letra_blanca"> {{ trans('cruds.analisisRiesgo.title') }} </font>
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('matriz_riesgo_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.matriz-riesgos.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/matriz-riesgos") || request()->is("admin/matriz-riesgos/*") ? "c-active" : "" }}">
                              <i class="fas fa-table iconos_menu letra_blanca">
                              </i>
                                <font class="letra_blanca"> {{ trans('cruds.matrizRiesgo.title') }} </font>
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        <li class="c-sidebar-nav-item">
            <a href="{{ route("admin.systemCalendar") }}" class="c-sidebar-nav-link {{ request()->is("admin/system-calendar") || request()->is("admin/system-calendar/*") ? "active" : "" }}">
                <i class="iconos_menu letra_blanca fa-fw fas fa-calendar">

                </i>
                <font class="letra_blanca"> Agenda </font>
            </a>
        </li>
        <li class="c-sidebar-nav-item">
            <a href="{{ route("admin.desk.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/desk") || request()->is("admin/desk/*") ? "active" : "" }}">
                <i class="iconos_menu letra_blanca fas fa-headset"></i>
                <font class="letra_blanca"> Centro de atención
 </font>
            </a>
        </li>
        @can('glosario_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.glosarios.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/glosarios") || request()->is("admin/glosarios/*") ? "active" : "" }}">
                    <i class="fa-fw fas fa-book iconos_menu letra_blanca">

                    </i>
                    <font class="letra_blanca"> {{ trans('cruds.glosario.title') }} </font>
                </a>
            </li>
        @endcan
        <li class="c-sidebar-nav-item">
            <a href="{{ route("admin.soporte.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/soporte.index") || request()->is("admin/soporte/*") ? "active" : "" }}">
                 <i class="fas fa-user-cog iconos_menu letra_blanca"></i>

                <font class="letra_blanca"> Soporte </font>
            </a>
        </li>

        <li class="c-sidebar-nav-title"><font class="letra_blanca">Normas</font></li>
        @can('isoveinticieteuno_access')

            <li class="c-sidebar-nav-item">
                <a class="c-sidebar-nav-link" href="{{ route("admin.iso27001.index") }}">
                    <i class="fa-fw fas fa-globe-americas iconos_menu letra_blanca"></i>
                    <font class="letra_blanca"> ISO 27001 </font>
                </a>
            </li>
        @endcan

        <li class="c-sidebar-nav-title"><font class="letra_blanca">Administración</font></li>
        @can('faq_management_access')
            <li class="c-sidebar-nav-dropdown">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fas fa-file-alt iconos_menu letra_blanca">

                    </i>
                    <font class="letra_blanca"> Configuracion de Datos </font>
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                {{--  @can('organizacione_access')
                      <li class="c-sidebar-nav-item">
                          <a href="{{ route("admin.organizaciones.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/organizaciones") || request()->is("admin/organizaciones/*") ? "active" : "" }}">
                              <i class="fa-fw fas fa-university iconos_menu letra_blanca" >

                              </i>
                              <font class="letra_blanca"> {{ trans('cruds.organizacione.title') }} </font>
                          </a>
                      </li>
                  @endcan--}}
                  @can('sede_access')
                  <li class="c-sidebar-nav-item">
                      <a href="{{ route("admin.sedes.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/sedes") || request()->is("admin/sedes/*") ? "active" : "" }}">
                          <i class="fas fa-map-marked-alt iconos_menu letra_blanca">

                          </i>
                          <font class="letra_blanca"> Sedes</font>
                      </a>
                  </li>
                @endcan

                <li class="c-sidebar-nav-dropdown">

                    <a class="c-sidebar-nav-dropdown-toggle" href="#">
                        <i class="fas fa-puzzle-piece iconos_menu letra_blanca">

                        </i>

                        <font class="letra_blanca "> Áreas </font>
                    </a>
                    <ul class="c-sidebar-nav-dropdown-items">

                        @can('area_access')

                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.areas.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/areas") || request()->is("admin/areas/*") ? "active" : "" }}">
                                {{--<i class="fas fa-puzzle-piece iconos_menu letra_blanca">

                                </i>--}}
                                &nbsp;&nbsp;&nbsp;

                                <i class="fab fa-adn iconos_menu letra_blanca">

                                </i>
                                <font class="letra_blanca"> Crear Áreas </font>
                            </a>
                        </li>
                        @endcan

                        <li class="c-sidebar-nav-item">

                            <a href="{{ route("admin.grupoarea.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/grupoarea") || request()->is("admin/grupoarea/*") ? "active" : "" }}">
                                {{--<i class="fas fa-puzzle-piece iconos_menu letra_blanca">

                                </i>--}}
                                &nbsp;&nbsp;&nbsp;
                                <i class="fas fa-cubes iconos_menu letra_blanca">

                                </i>

                                <font class="letra_blanca"> Grupo Áreas </font>
                            </a>
                        </li>


                    </ul>
                </li>
                  @can('user_access')
                  <li class="c-sidebar-nav-item">
                      <a href="{{ route("admin.empleados.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/empleados") || request()->is("admin/empleados/*") ? "active" : "" }}">
                          <i class="fa-fw fas fa-user iconos_menu letra_blanca" >

                          </i>
                          <font class="letra_blanca"> Empleados </font>
                      </a>
                  </li>
                   @endcan
                  @can('activo_access')
                      <li class="c-sidebar-nav-item">
                          <a href="{{ route("admin.activos.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/activos") || request()->is("admin/activos/*") ? "active" : "" }}">
                            <i class="fa-fw fas fa-laptop iconos_menu letra_blanca" >

                            </i>
                              <font class="letra_blanca"> Inventario de Activos</font>
                          </a>
                      </li>
                  @endcan
                  @can('tipoactivo_access')
                      <li class="c-sidebar-nav-item">
                          <a href="{{ route("admin.tipoactivos.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/tipoactivos") || request()->is("admin/tipoactivos/*") ? "active" : "" }}">
                        <i class="fas fa-th-list iconos_menu letra_blanca"></i>
                              <font class="letra_blanca"> Categorias de Activos</font>
                          </a>
                      </li>
                  @endcan
                   @can('tipoactivo_access')
                      <li class="c-sidebar-nav-item">
                          <a href="{{ route("admin.categoria-capacitacion.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/tipoactivos") || request()->is("admin/tipoactivos/*") ? "active" : "" }}">
                        <i class="fas fa-th-list iconos_menu letra_blanca"></i>
                              <font class="letra_blanca"> Categorias de Capacitaciones</font>
                          </a>
                      </li>
                  @endcan
                  @can('tipoactivo_access')
                      <li class="c-sidebar-nav-item">
                          <a href="{{ route("admin.macroprocesos.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/tipoactivos") || request()->is("admin/tipoactivos/*") ? "active" : "" }}">
                        <i class="fas fa-th-list iconos_menu letra_blanca"></i>
                              <font class="letra_blanca"> Macroprocesos</font>
                          </a>
                      </li>
                  @endcan
                  @can('tipoactivo_access')
                      <li class="c-sidebar-nav-item">
                          <a href="{{ route("admin.procesos.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/procesos") || request()->is("admin/procesos/*") ? "active" : "" }}">
                        <i class="fas fa-th-list iconos_menu letra_blanca"></i>
                              <font class="letra_blanca"> Procesos</font>
                          </a>
                      </li>
                  @endcan
                </ul>
            </li>
        @endcan

        @can('user_management_access')
            <li class="c-sidebar-nav-dropdown">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-users iconos_menu letra_blanca">

                    </i>
                    <font class="letra_blanca"> {{ trans('cruds.userManagement.title') }} </font>
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('permission_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.permissions.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/permissions") || request()->is("admin/permissions/*") ? "active" : "" }}">
                                <i class="fa-fw fas fa-unlock-alt iconos_menu letra_blanca" >

                                </i>
                                <font class="letra_blanca"> {{ trans('cruds.permission.title') }} </font>
                            </a>
                        </li>
                    @endcan
                    @can('role_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.roles.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/roles") || request()->is("admin/roles/*") ? "active" : "" }}">
                                <i class="fa-fw fas fa-briefcase iconos_menu letra_blanca" >

                                </i>
                                <font class="letra_blanca"> {{ trans('cruds.role.title') }} </font>
                            </a>
                        </li>
                    @endcan
                    @can('user_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.users.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/users") || request()->is("admin/users/*") ? "active" : "" }}">
                                <i class="fa-fw fas fa-user iconos_menu letra_blanca" >

                                </i>
                                <font class="letra_blanca"> {{ trans('cruds.user.title') }} </font>
                            </a>
                        </li>
                    @endcan

                    @can('controle_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.controles.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/controles") || request()->is("admin/controles/*") ? "active" : "" }}">
                                <i class="fa-fw fas fa-screwdriver iconos_menu letra_blanca" >

                                </i>
                                <font class="letra_blanca"> {{ trans('cruds.controle.title') }} </font>
                            </a>
                        </li>
                    @endcan
                    @can('audit_log_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.audit-logs.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/audit-logs") || request()->is("admin/audit-logs/*") ? "active" : "" }}">
                                <i class="fa-fw fas fa-file-alt iconos_menu letra_blanca" >

                                </i>
                                <font class="letra_blanca"> {{ trans('cruds.auditLog.title') }} </font>
                            </a>
                        </li>
                    @endcan
                    @can('puesto_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.puestos.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/puestos") || request()->is("admin/puestos/*") ? "active" : "" }}">
                                <i class="fa-fw fas fa-user-md iconos_menu letra_blanca" >

                                </i>
                                <font class="letra_blanca"> {{ trans('cruds.puesto.title') }} </font>
                            </a>
                        </li>
                    @endcan
                    @can('user_alert_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.user-alerts.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/user-alerts") || request()->is("admin/user-alerts/*") ? "active" : "" }}">
                                <i class="fa-fw fas fa-bell iconos_menu letra_blanca" >

                                </i>
                                <font class="letra_blanca"> {{ trans('cruds.userAlert.title') }} </font>
                            </a>
                        </li>
                    @endcan
                    @can('enlaces_ejecutar_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.enlaces-ejecutars.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/enlaces-ejecutars") || request()->is("admin/enlaces-ejecutars/*") ? "active" : "" }}">
                                <i class="fa-fw fas fa-cogs iconos_menu letra_blanca" >

                                </i>
                                <font class="letra_blanca"> {{ trans('cruds.enlacesEjecutar.title') }} </font>
                            </a>
                        </li>
                    @endcan
                    @can('team_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.teams.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/teams") || request()->is("admin/teams/*") ? "active" : "" }}">
                                <i class="fa-fw fas fa-users iconos_menu letra_blanca" >

                                </i>
                                <font class="letra_blanca"> {{ trans('cruds.team.title') }} </font>
                            </a>
                        </li>
                    @endcan
                    @can('estado_incidente_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.estado-incidentes.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/estado-incidentes") || request()->is("admin/estado-incidentes/*") ? "active" : "" }}">
                                <i class="fa-fw fab fa-stripe-s iconos_menu letra_blanca" >

                                </i>
                                <font class="letra_blanca"> {{ trans('cruds.estadoIncidente.title') }} </font>
                            </a>
                        </li>
                    @endcan
                    @can('estatus_plan_trabajo_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.estatus-plan-trabajos.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/estatus-plan-trabajos") || request()->is("admin/estatus-plan-trabajos/*") ? "active" : "" }}">
                                <i class="fa-fw fas fa-cogs iconos_menu letra_blanca" >

                                </i>
                                <font class="letra_blanca"> {{ trans('cruds.estatusPlanTrabajo.title') }} </font>
                            </a>
                        </li>
                    @endcan
                    @can('estado_documento_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.estado-documentos.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/estado-documentos") || request()->is("admin/estado-documentos/*") ? "active" : "" }}">
                                <i class="fa-fw fas fa-cogs iconos_menu letra_blanca" >

                                </i>
                                <font class="letra_blanca"> {{ trans('cruds.estadoDocumento.title') }} </font>
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @can('plan_base_actividade_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.plan-base-actividades.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/plan-base-actividades") || request()->is("admin/plan-base-actividades/*") ? "active" : "" }}">
                    <i class="fa-fw fas fa-cogs iconos_menu letra_blanca">

                    </i>
                    <font class="letra_blanca"> {{ trans('cruds.planBaseActividade.title') }} </font>
                </a>
            </li>
        @endcan
        @can('faq_management_access')
            <li class="c-sidebar-nav-dropdown">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-question iconos_menu letra_blanca">

                    </i>
                    <font class="letra_blanca"> {{ trans('cruds.faqManagement.title') }} </font>
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('faq_category_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.faq-categories.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/faq-categories") || request()->is("admin/faq-categories/*") ? "active" : "" }}">
                                <i class="fa-fw fas fa-briefcase iconos_menu letra_blanca" >

                                </i>
                                <font class="letra_blanca"> {{ trans('cruds.faqCategory.title') }} </font>
                            </a>
                        </li>
                    @endcan
                    @can('faq_question_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.faq-questions.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/faq-questions") || request()->is("admin/faq-questions/*") ? "active" : "" }}">
                                <i class="fa-fw fas fa-question iconos_menu letra_blanca" >

                                </i>
                                <font class="letra_blanca"> {{ trans('cruds.faqQuestion.title') }} </font>
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan

        @if(\Illuminate\Support\Facades\Schema::hasColumn('teams', 'owner_id') && \App\Models\Team::where('owner_id', auth()->user()->id)->exists())
            <li class="c-sidebar-nav-item">
                <a class="{{ request()->is("admin/team-members") || request()->is("admin/team-members/*") ? "active" : "" }} c-sidebar-nav-link" href="{{ route("admin.team-members.index") }}">
                    <i class="iconos_menu letra_blanca fa-fw fa fa-users">
                    </i>
                    <span>{{ trans("global.team-members") }}</span>
                </a>
            </li>
        @endif
        @can('lista_de_verificacion_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/control-documentos*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                    </i>
                    <font class="letra_blanca"> {{ trans('cruds.listaDeVerificacion.title') }} </font>
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('control_documento_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.control-documentos.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/control-documentos") || request()->is("admin/control-documentos/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                                </i>
                                <font class="letra_blanca">{{ trans('cruds.controlDocumento.title') }}</font>
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        <li class="c-sidebar-nav-item">
            <a href="{{ url('sitemap') }}" class="c-sidebar-nav-link">
                <i class="iconos_menu letra_blanca fas fa-fw fa-sitemap">

                </i>
                <font class="letra_blanca">Mapa de sitio</font>
            </a>
        </li>

    </ul>

</div>

<script>
    var a = document.getElementsByClassName("active");
    for(var i = 0; i < a.length; i++)
        a[i].className += " c-active";


    var ida = document.getElementsByClassName("c-active");
    for(var i = 0; i < ida.length; i++)
        ida[i].id += "seleccionado";



    document.getElementById('seleccionado').parentNode.classList.add('c-show');

    document.getElementById('seleccionado').parentNode.parentNode.classList.add('c-show');

    document.getElementById('seleccionado').parentNode.parentNode.parentNode.classList.add('c-show');

    document.getElementById('seleccionado').parentNode.parentNode.parentNode.parentNode.classList.add('c-show');

    document.getElementById('seleccionado').parentNode.parentNode.parentNode.parentNode.parentNode.classList.add('c-show');
</script>
