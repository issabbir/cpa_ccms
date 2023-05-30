<div class="card">
    <div class="card-title">Category List</div>
    <div class="card-body">
        <section id="horizontal-vertical">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body card-dashboard">
                                <div class="table-responsive">
                                    <table class="table mdl-data-table table-sm dataTable">
                                        <thead>
                                        <tr>
                                            <th>Category Name</th>
                                            <th>In order</th>
{{--                                            <th>Parent Category</th>--}}
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($categories as $category)
                                            @include('ccms.setup.category.item', ['category' => $category, "space"=>""])
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
