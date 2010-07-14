class CreateRewards < ActiveRecord::Migration
  def self.up
    create_table :rewards do |t|
      t.string :name
      t.integer :rate
      t.integer :ally
      t.integer :horda
      t.string :picture
      t.integer :wowhead

      t.timestamps
    end
  end

  def self.down
    drop_table :rewards
  end
end
