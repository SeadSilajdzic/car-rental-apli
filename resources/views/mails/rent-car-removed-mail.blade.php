Hello {{ $user->name }}. <br>
We just wanted to let you know that your car-rent appointment has been removed.<br>

You have rented a car with {{ $rent->registration_license }} registration license for {{ $rent->date_range }} days ({{ $rent->date_from }} / {{ $rent->date_to }}). <br>
Total cost of this rent was ${{ $rent->total_rent_price }}. <br>

Sincerely,
car-rental company
