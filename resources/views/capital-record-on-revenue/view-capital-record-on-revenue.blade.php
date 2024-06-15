@extends('layout.master')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Capital Record On Revenue</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Master</a></li>
                        <li class="breadcrumb-item active">Capital Record On Revenue</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content-header -->
    <section class="content">
        <div class="container-fluid">
            @if (session()->has('success'))
                <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show">
                    <div class="alert alert-success">
                        {{ session()->get('success') }}
                    </div>
                </div>
            @endif

            @if (session()->has('update'))
                <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show">
                    <div class="alert alert-success">
                        {{ session()->get('update') }}
                    </div>
                </div>
            @endif
            @if (session()->has('error'))
                <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show">
                    <div class="alert alert-danger">
                        {{ session()->get('error') }}
                    </div>
                </div>
            @endif
            @if (session()->has('delete'))
                <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show">
                    <div class="alert alert-danger">
                        {{ session()->get('delete') }}
                    </div>
                </div>
            @endif
            <div class="row">
                <div class="col-12 float-sm-right">
                    <div class="card">
                        <div class="card-header">
                            
                            <button type="submit" class="btn btn-dark"
                                onclick="window.location='{{ url('create-capital-record-on-revenue') }}'">Add Capital Record On Revenue
                            </button>
                        </div>

                        <div class="card-body">
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Sr No.</th>
                                        <th>Work Code</th>
                                        <th>Major Head</th>
                                        <th>Scheme Name</th>
                                        <th>Estimated Cost</th>
                                        <th>Utilize Pre. Year Budget</th>
                                        <th>Funds required for completion</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td>001</td>
                                                <td>2403-00-789-19-S00N</td>
                                                <td>Animal Welfare Board -42-Grants-in-Aid General (Non-Salary)</td>
                                                <td>178</td>
                                                <td>150</td>
                                                <td>50</td>
                                                <td>
                                                    <a 
                                                        title="View constituency"><button class="btn btn-info btn-sm"><i
                                                                class="fa fa-eye" aria-hidden="true"></i> View</button></a>
                                                    <a 
                                                        title="Edit constituency">
                                                        <button class="btn btn-primary btn-sm"><i
                                                                class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit
                                                        </button>
                                                    </a>
                                                        <button type="submit" class="btn btn-danger btn-sm"
                                                            title="Delete Contact"><i class="fa fa-trash-o"
                                                                aria-hidden="true"></i> Delete
                                                        </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>1</td>
                                                <td>002</td>
                                                <td>2403-00-789-20-S05N</td>
                                                <td>National Livestock Mission -42-Grants-in-Aid General (Non-Salary)</td>
                                                <td>19</td>
                                                <td>13</td>
                                                <td>9</td>
                                                <td>
                                                    <a 
                                                        title="View constituency"><button class="btn btn-info btn-sm"><i
                                                                class="fa fa-eye" aria-hidden="true"></i> View</button></a>
                                                    <a 
                                                        title="Edit constituency">
                                                        <button class="btn btn-primary btn-sm"><i
                                                                class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit
                                                        </button>
                                                    </a>
                                                        <button type="submit" class="btn btn-danger btn-sm"
                                                            title="Delete Contact"><i class="fa fa-trash-o"
                                                                aria-hidden="true"></i> Delete
                                                        </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>1</td>
                                                <td>003</td>
                                                <td>2403-00-789-20-S10N</td>
                                                <td>National Livestock Mission -42-Grants-in-Aid General (Non-Salary)</td>
                                                <td>128</td>
                                                <td>90</td>
                                                <td>35</td>
                                                <td>
                                                    <a 
                                                        title="View constituency"><button class="btn btn-info btn-sm"><i
                                                                class="fa fa-eye" aria-hidden="true"></i> View</button></a>
                                                    <a 
                                                        title="Edit constituency">
                                                        <button class="btn btn-primary btn-sm"><i
                                                                class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit
                                                        </button>
                                                    </a>
                                                        <button type="submit" class="btn btn-danger btn-sm"
                                                            title="Delete Contact"><i class="fa fa-trash-o"
                                                                aria-hidden="true"></i> Delete
                                                        </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>1</td>
                                                <td>004</td>
                                                <td>2403-00-789-20-S30N</td>
                                                <td>National Livestock Mission -42-Grants-in-Aid General (Non-Salary)</td>
                                                <td>101</td>
                                                <td>98</td>
                                                <td>38</td>
                                                <td>
                                                    <a 
                                                        title="View constituency"><button class="btn btn-info btn-sm"><i
                                                                class="fa fa-eye" aria-hidden="true"></i> View</button></a>
                                                    <a 
                                                        title="Edit constituency">
                                                        <button class="btn btn-primary btn-sm"><i
                                                                class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit
                                                        </button>
                                                    </a>
                                                        <button type="submit" class="btn btn-danger btn-sm"
                                                            title="Delete Contact"><i class="fa fa-trash-o"
                                                                aria-hidden="true"></i> Delete
                                                        </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>1</td>
                                                <td>005</td>
                                                <td>2403-00-789-24-S00N</td>
                                                <td>Cattle Feed Subsidy to Below Poverty Line Families -63-Subsidy</td>
                                                <td>114</td>
                                                <td>109</td>
                                                <td>78</td>
                                                <td>
                                                    <a 
                                                        title="View constituency"><button class="btn btn-info btn-sm"><i
                                                                class="fa fa-eye" aria-hidden="true"></i> View</button></a>
                                                    <a 
                                                        title="Edit constituency">
                                                        <button class="btn btn-primary btn-sm"><i
                                                                class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit
                                                        </button>
                                                    </a>
                                                        <button type="submit" class="btn btn-danger btn-sm"
                                                            title="Delete Contact"><i class="fa fa-trash-o"
                                                                aria-hidden="true"></i> Delete
                                                        </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>1</td>
                                                <td>006</td>
                                                <td>2403-00-789-25-S00N</td>
                                                <td>5000 Broiler Scheme (Him Kukkut Palan Yojna)</td>
                                                <td>136</td>
                                                <td>107</td>
                                                <td>60</td>
                                                <td>
                                                    <a 
                                                        title="View constituency"><button class="btn btn-info btn-sm"><i
                                                                class="fa fa-eye" aria-hidden="true"></i> View</button></a>
                                                    <a 
                                                        title="Edit constituency">
                                                        <button class="btn btn-primary btn-sm"><i
                                                                class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit
                                                        </button>
                                                    </a>
                                                        <button type="submit" class="btn btn-danger btn-sm"
                                                            title="Delete Contact"><i class="fa fa-trash-o"
                                                                aria-hidden="true"></i> Delete
                                                        </button>
                                                </td>
                                            </tr>
                                </tbody>
                            </table>
                        </div>
                            <div class="col-sm-12">
                                <ol class="float-sm-right">
                                </ol>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection