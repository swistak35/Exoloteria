class CreateWinners < ActiveRecord::Migration
  def self.up
    create_table :winners do |t|
      t.string :nick
      t.references :reward
      t.string :fraction

      t.timestamps
    end
  end

  def self.down
    drop_table :winners
  end
end
